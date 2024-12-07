import axios from "axios";
const baseUrl = import.meta.env.VITE_APP_API_URL;

const getters = {
    getFilter: state => {
        return state.filter;
    },
    getTags: state => {
        return state.tags;
    },
    getSidebarFilter: state => {
        return state.toggleSidebarFiler;
    },
    getActiveFilter: state => {
        return state.activeFilter;
    },
    getSearchedRooms: state => {
        return state.searchedRooms;
    }
}

const actions =  {
    async fetchTags({commit}) {
        const data = await axios.get(`${baseUrl}/api/room-tags`);
        commit('setTags', data);
    },
    async fetchRoomsWithFilter({commit, state}) {
        const data = await axios.get(`${baseUrl}/api/rooms`);
        console.log(data);
    }
}

const mutations = {
    setTags(state, val) {
        state.tags = val;
    },
    setSidebarFilter(state, val) {
        state.toggleSidebarFiler = val;
    },
    setActiveFilter(state, val) {
        state.activeFilter = val;
    },
    setFilterWithQuery(state, val) {
        state.activeFilter = setFilter(val);
    }
}


const state = {
    searchedRooms: [],
    filter: {
        locations: [
            'Europe',
            'North America',
            'South America and Caribic',
            'Asia',
            'Africa',
            'Oceania',
            'Middle East',
            'Aaland Islands',
            'Afghanistan',
            'Albania',
            'Algeria',
            'American Samoa',
            'Andorra',
            'Angola',
            'Anguilla',
            'Antigua And Barbuda',
            'Argentina',
            'Armenia',
            'Aruba',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bermuda',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'British Virgin Islands',
            'Brunei',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Cape Verde',
            'Cayman Islands',
            'Central African Republic',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Congo',
            'Cook Islands',
            'Costa Rica',
            "Cote D'Ivoire",
            'Croatia',
            'Cuba',
            'Curaçao',
            'Cyprus',
            'Czech Republic',
            'Denmark',
            'Dominica',
            'Dominican Republic',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Eritrea',
            'Estonia',
            'Fiji',
            'Finland',
            'France',
            'French Guiana',
            'French Polynesia',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Gibraltar',
            'Greece',
            'Grenada',
            'Guam',
            'Guatemala',
            'Guernsey',
            'Guinea',
            'Guyana',
            'Haiti',
            'Honduras',
            'Hong Kong',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland',
            'Isle of Man',
            'Israel',
            'Italy',
            'Ivory Coast',
            'Jamaica',
            'Japan',
            'Kazakhstan',
            'Kenya',
            'Korea North',
            'Korea South',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Liberia',
            'Libya',
            'Lichtenstein',
            'Lithuania',
            'Luxembourg',
            'Macau',
            'Macedonia',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Mauritius',
            'Myanmar',
            'Mexico',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Namibia',
            'Nepal',
            'Netherlands',
            'New Caledonia',
            'New Zealand',
            'Nicaragua',
            'Nigeria',
            'Norway',
            'Pakistan',
            'Palau',
            'Palestine',
            'Panama',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Puerto Rico',
            'Qatar',
            'Reunion',
            'Romania',
            'Russia',
            'San Marino',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Singapore',
            'Slovakia',
            'Slovenia',
            'Somalia',
            'South Africa',
            'Spain',
            'Sri Lanka',
            'Suriname',
            'Sweden',
            'Switzerland',
            'Syria',
            'Taiwan',
            'Thailand',
            'Trinidad And Tobago',
            'Tunisia',
            'Turkey',
            'Turks And Caicos Islands',
            'Tuvalu',
            'UAE',
            'UK',
            'USA',
            'Uganda',
            'Ukraine',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Venezuela',
            'Vietnam',
            'Virgin Islands (U.S.)',
            'Yemen',
            'Zambia',
            'Zanzibar',
            'Zimbabwe',
        ],
        ages: ['18-19', '20-29', '30-39', '40-49', '50+'],
        genders: ['Female', 'Male', 'Couple', 'Trans'],
        chats: ['chaturbate', 'bongacams', 'myfreecams', 'cam4', 'camsoda', 'stripchat'],
        statuses: ['free chat', 'group show', 'private chat', 'ticket show', 'away', 'true private'],
        body_types : ['Petite', 'Slim', 'Athletic', 'Average', 'Curvy', 'Muscular', 'BBW', 'Other'],
        ethnicity : ['Arabian', 'Asian', 'Black/Ebony', 'Indian', 'Hispanic', 'Middle Eastern', 'White', 'Other'],
        eye_colors : ['Black', 'Brown', 'Blue', 'Green', 'Hazel', 'Gray', 'Other'],
        hair_color : ['black', 'brown', 'Red', 'Blonde', 'Other'],
        hair_length : ['Bold', 'Short', 'Shoulder', 'Long', 'Other'],
        height : ['<150 cm', '150 - 154 cm', '155 - 159 cm', '160 - 164 cm', '165 - 169 cm', '170 - 174 cm', '175 - 179 cm', '>180 cm'],
        language : ['English', 'Spanish', 'Russian', 'French', 'German', 'Italian', 'Dutch', 'Portuguese', 'Other'],
        pb_size : ['Tiny', 'Small', 'Average', 'Big', 'Huge', 'Other'],
        pubic_hair : ['Shaved', 'Trimmed', 'Hairy', 'Other'],
        sex_orientation : ['Straight', 'Bi-curious', 'Bisexual', 'Gay/Lesbian', 'Other'],
        weight : ['<50 kg', '50 - 54 kg', '55 - 59 kg', '60 - 64 kg', '65 - 69 kg', '70 - 74 kg', '75 - 79 kg', '>=80 kg'],
        tag: [],
    },
    tags: [],
    toggleSidebarFiler: false,
    activeFilter: {
        locations: [],
        ages: [],
        genders: [],
        chats: [],
        statuses: [],
        body_types: [],
        ethnicity: [],
        eye_colors: [],
        hair_color: [],
        hair_length: [],
        height: [],
        language: [],
        pb_size: [],
        pubic_hair: [],
        sex_orientation: [],
        weight: [],
        tag: [],
        showJustHDRooms: false,
        showJustNewModels: false,
        thumbnail: true,
    },
}

function setFilter(query) {
    let filter = {
        locations: [],
        ages: [],
        genders: [],
        chats: [],
        statuses: [],
        body_types: [],
        ethnicity: [],
        eye_colors: [],
        hair_color: [],
        hair_length: [],
        height: [],
        language: [],
        pb_size: [],
        pubic_hair: [],
        sex_orientation: [],
        weight: [],
        tag: [],
        showJustHDRooms: false,
        showJustNewModels: false,
        thumbnail: true,
    };

    for(const fi in filter) {
        if (fi === "showJustNewModels") {
            filter.showJustNewModels = query.get("showJustNewModels") === "true";
            continue;
        }
        if (fi === "showJustHDRooms") {
            filter.showJustHDRooms = query.get("showJustHDRooms") === "true";
            continue;
        }
        if (fi === "thumbnail") {
            filter.thumbnail = query.get("thumbnail") !== "true";
            continue;
        }
        if (query.get(`filter[${fi}][]`)) {
            query.get(`filter[${fi}][]`).split(",").forEach(val => filter[fi].push(val));
        }
    }

    return filter;
}

const filter = {
    state,
    getters,
    actions,
    mutations
};

export default filter;