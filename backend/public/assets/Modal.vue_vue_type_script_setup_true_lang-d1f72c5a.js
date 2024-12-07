import{z as B,ci as z,j as O,A as $,o as a,c,e as p,b as l,w as o,ao as s,ae as j,a as t,ad as y,cA as x,n as r,x as i,m as n,ah as C,af as V}from"./multiselect-82d1182f.js";import{H as g,I as N,J as S}from"./index-5e60d8d5.js";const A={class:"flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0"},I={class:"text-sm text-gray-500"},J=B({__name:"Modal",props:{open:{type:Boolean,default:!1},type:{},centered:{type:Boolean,default:!1},alignButtons:{default:"left"},externalOpen:{type:Boolean,default:!1},size:{default:"md"}},emits:["toggleOpen"],setup(h,{emit:w}){const u=h,v=z(),b=O(()=>!!v.title),f=$(u.open),k=w,m=(e=!1)=>{f.value=e,k("toggleOpen")};return(e,d)=>(a(),c("div",null,[p(e.$slots,"trigger",{setIsOpen:m}),l(s(V),{as:"template",show:e.externalOpen?u.open:f.value},{default:o(()=>[l(s(j),{as:"div",open:e.externalOpen?u.open:f.value,class:"fixed inset-0 z-50 overflow-y-auto",onClose:m},{default:o(()=>[d[1]||(d[1]=t("button",{class:"absolute h-0 w-0 opacity-0"},null,-1)),t("div",A,[l(s(y),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:o(()=>[l(s(x),{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"})]),_:1}),d[0]||(d[0]=t("span",{class:"hidden sm:inline-block sm:h-screen sm:align-middle","aria-hidden":"true"}," ​ ",-1)),l(s(y),{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:o(()=>[t("div",{class:r(["relative inline-block transform rounded-lg bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:p-6 sm:align-middle",{"sm:max-w-md":e.size==="sm","sm:max-w-xl":e.size==="md","sm:max-w-5xl":e.size==="lg"}])},[t("div",{class:r(["sm:flex",{"sm:items-start":!e.centered,"sm:flex-col sm:items-center":e.centered}])},[e.type?(a(),c("div",{key:0,class:r(["mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10",{"bg-danger-100":e.type==="danger","bg-success-100":e.type==="success","bg-info-100":e.type==="info","bg-warning-100":e.type==="warning"}])},[e.type==="danger"?(a(),i(s(g),{key:0,class:"h-6 w-6 text-danger-600","aria-hidden":"true"})):n("",!0),e.type==="success"?(a(),i(s(N),{key:1,class:"h-6 w-6 text-success-600","aria-hidden":"true"})):n("",!0),e.type==="info"?(a(),i(s(S),{key:2,class:"h-6 w-6 text-info-600","aria-hidden":"true"})):n("",!0),e.type==="warning"?(a(),i(s(g),{key:3,class:"h-6 w-6 text-warning-600","aria-hidden":"true"})):n("",!0)],2)):n("",!0),t("div",{class:r(["text-center",{"w-full":!e.type,"sm:text-left":!e.centered,"sm:ml-4":e.type&&!e.centered,"mt-3 sm:mt-4":e.type&&e.centered,"sm:flex-col sm:items-center":e.centered}])},[b.value?(a(),i(s(C),{key:0,as:"h3",class:"mb-2 text-lg font-medium leading-6 text-gray-900"},{default:o(()=>[p(e.$slots,"title")]),_:3})):n("",!0),t("div",I,[p(e.$slots,"content",{setIsOpen:m})])],2)],2),t("div",{class:r(["mt-5 gap-4",{"sm:mt-4 sm:flex":!e.centered,"sm:justify-end":e.alignButtons==="right","sm:justify-start":e.alignButtons==="left","grid auto-cols-fr grid-flow-col sm:mt-6 sm:items-center":e.centered,"sm:ml-10 sm:pl-4":e.type&&!e.centered}])},[p(e.$slots,"buttons",{setIsOpen:m})],2)],2)]),_:3})])]),_:3},8,["open"])]),_:3},8,["show"])]))}});export{J as _};
