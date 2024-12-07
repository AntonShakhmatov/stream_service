<template>
    <TransitionRoot :show="open" as="Fragment">
        <Dialog as="div" class="relative z-50" onClose="onClose">
            <TransitionChild
                as="Fragment"
                enter="ease-out duration-300"
                enterFrom="opacity-0"
                enterTo="opacity-100"
                leave="ease-in duration-200"
                leaveFrom="opacity-100"
                leaveTo="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild
                        as="Fragment"
                        enter="ease-out duration-300"
                        enterFrom="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enterTo="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100 translate-y-0 sm:scale-100"
                        leaveTo="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-secondary-color text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                            <header class="p-4 flex gap-2 items-center justify-between pb-2 border-b border-background-primary">
                                <h1 class="text-2xl font-bold text-white">Notes</h1>

                                <button
                                    @click="onClose"
                                    class="block w-max px-2 ml-auto text-white text-3xl"
                                >
                                    <font-awesome-icon :icon="['fas', 'times']"/>
                                </button>
                            </header>
                            <main class="flex h-[500px]" v-if="notes.length">
                                <ul
                                    role="list"
                                    class="px-4 w-96 divide-y divide-background-primary overflow-hidden overflow-ellipsis overflow-y-scroll border-r border-background-primary"
                                >
                                    <li
                                        v-for="note in notes"
                                        :key="note?.room?._id"
                                        @click="() => setSelectedNote(note)"
                                        class="flex py-4 cursor-pointer"
                                        :class="{'bg-primary-color text-white': note === selectedNote}"
                                    >
                                        <img
                                            class="h-5 w-5 rounded-full"
                                            :src="chatLogo(note?.room)"
                                            :alt="note?.room?.username"
                                        />
                                        <div class="ml-3">
                                            <p
                                                class="text-sm font-medium whitespace-nowrap text-primary-color"
                                                :class="{'text-white': note === selectedNote, 'text-primary-color': note !== selectedNote}"
                                            >
                                                {{ note?.room?.username }}
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="flex flex-col w-full">
                                    <div class="flex items-center w-full border-b border-background-primary justify-between">
                                        <h2 class="p-4 text-2xl text-white font-bold">
                                            {{ room?.username }}
                                        </h2>
                                        <button v-if="selectedNote?.room"  @click="() => removeNote(selectedNote)" class="pr-4">
                                            <font-awesome-icon :icon="['fas', 'trash']" class="h-4 w-4 text-red-600" />
                                        </button>
                                    </div>


                                    <form
                                        class="h-full flex flex-col"
                                        @submit.prevent="handleSubmit"
                                    >
                                        <div class="p-4">
                                            <label
                                                for="comment"
                                                class="block text-sm font-medium text-white"
                                            >
                                                Add your note
                                            </label>
                                            <div class="h-full mt-1">
                                                <textarea
                                                    rows="10"
                                                    name="note"
                                                    class="block w-full h-full text-black bg-background-primary rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                                    v-model="note_text"
                                                    required="required"
                                                />
                                            </div>
                                        </div>
                                        <div class="mt-auto  px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                            <button type="submit" class="!px-4 !py-2 bg-primary-color rounded-md text-white">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </main>
                            <div v-else class="text-white h-[500px] min-w-[500px] flex items-center justify-center font-medium text-2xl">You have not added any note</div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import StatusIcon from "@/components/partials/StatusIcon.vue";
import {mapGetters, mapMutations, mapActions} from "vuex";
import auth from '@/store/auth/auth';
import dayjs from "dayjs";
import { toast } from 'vue3-toastify';

export default {
    name: "NotesModal",
    components: {StatusIcon, DialogPanel, TransitionChild, Dialog, TransitionRoot, dayjs},
    data() {
        return {
            open: false,
            notes: [],
            isHidden: false,
            isFollowed: false,
            isLiked: false,
            photos: [],
            user: [],
            selectedNote: [],
            room: [],
            note_text: "",
        }
    },
    async created() {
        await this.fetchUser();
        this.user = this.getUser;
        this.selectedNote = this.user?.notes ? this.user?.notes[0] : [];
    },
    methods: {
        ...mapActions('auth', [
            "fetchUser",
        ]),
        ...mapMutations([
            'setNotesModal',
            "setOpenNotesModal",
        ]),
        onClose() {
            this.setOpenNotesModal(false);
        },
        setSelectedNote(note) {
            this.selectedNote = note;
            this.note_text = note.note.note;
            this.room = note.room;
        },
        chatLogo(room) {
            return `/assets/chats/${room.chat}.png`;
        },
        handleSubmit() {
            if (this.$cookies.get("my_token")) {
                auth.post("api/room-notes", {
                    room_id: this.room._id,
                    note: this.note_text,
                }).then(async res => {
                    await this.fetchUser();

                    this.setSelectedNoteWithUser();
                    toast.success("Successfully saved note");
                });
            } else {
                this.$router.push({name: 'login'})
            }
        },
        removeNote() {
            if (this.$cookies.get('my_token')) {
                auth.delete(`api/room-notes/${this.selectedNote.note._id}`).then(async res => {
                    await this.fetchUser();
                    this.notes = this.getUser.notes;
                    this.setSelectedNote(this.notes[0]);
                    toast.success("Successfully removed note");
                })
            }
        },
        setSelectedNoteWithUser() {
            this.notes = this.getUser.notes;
            this.notes.forEach(note => {
                if (note.room._id === this.room?._id) {
                    this.setSelectedNote(note);
                }
            })
        }
    },
    computed: {
        ...mapGetters('auth',[
            "getUser",
        ]),
        ...mapGetters([
            "getOpenNotesModal",
            "getNotesModal",
        ])
    },
    watch: {
        'getOpenNotesModal': async function () {
            if (this.getOpenNotesModal) {
                await this.fetchUser();

                if (this.getNotesModal?._id) {
                    this.room = this.getNotesModal;
                } else {
                    this.room = this.getUser.notes[0]?.room;
                }
                console.log('in watcher', this.room);
                this.setSelectedNoteWithUser();

            }
            this.open = !this.open;
        }
    }
}
</script>

<style scoped>

</style>
