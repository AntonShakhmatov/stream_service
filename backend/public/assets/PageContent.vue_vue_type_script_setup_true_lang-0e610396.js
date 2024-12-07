import{Z as _}from"./index-5e60d8d5.js";import{z as m,o as t,c as l,x,ao as r,m as n,a as s,t as c,e as a,n as f,ci as b,j as h,b as d,w as u,aB as y,az as w,aC as v}from"./multiselect-82d1182f.js";const k={class:"flex w-full flex-wrap items-center justify-between gap-2 sm:flex-nowrap"},g={class:"mr-auto"},$={key:0,class:"text-xl font-medium leading-6 text-gray-900"},B={key:1,class:"mt-1 text-sm text-gray-500"},C={class:"flex-shrink-0"},I=m({__name:"PageHeader",props:{title:{},subtitle:{},sticky:{type:Boolean,default:!1}},setup(p){return(e,o)=>(t(),l("div",{class:f(["w-full",{"sticky top-0 z-30":e.sticky}])},[e.title?(t(),x(r(_),{key:0,title:e.title},null,8,["title"])):n("",!0),s("header",{class:f(["flex w-full border-b border-gray-200 bg-white px-4 sm:px-6",{"py-3 sm:py-4":e.subtitle,"py-3 sm:py-5":!e.subtitle}])},[o[0]||(o[0]=s("div",{class:"h-10"},null,-1)),s("div",k,[s("div",g,[e.title?(t(),l("h3",$,c(e.title),1)):n("",!0),e.subtitle?(t(),l("p",B,c(e.subtitle),1)):n("",!0)]),s("div",C,[a(e.$slots,"default")])])],2)],2))}}),z={class:"relative flex flex-1 items-stretch overflow-hidden dark bg-slate-800"},N={key:0,class:"flex flex-1 flex-col"},S={class:"flex-1 overflow-y-auto pb-20"},V={class:"mx-auto mt-6 w-full max-w-screen-2xl px-4 sm:px-6 md:px-8"},j={key:1,class:"flex-1 overflow-y-auto pb-20"},P={class:"mx-auto mt-6 w-full max-w-screen-2xl px-4 sm:px-6 md:px-8"},T=m({__name:"PageContent",setup(p){const e=b(),o=h(()=>!!e.tabs);return(i,D)=>(t(),l("div",z,[o.value?(t(),l("div",N,[d(r(v),null,{default:u(()=>[d(r(y),{class:"flex w-full border-b border-gray-200 bg-white px-4 sm:px-6"},{default:u(()=>[a(i.$slots,"tabs")]),_:3}),s("div",S,[s("div",V,[d(r(w),null,{default:u(()=>[a(i.$slots,"default")]),_:3})])])]),_:3})])):(t(),l("div",j,[s("div",P,[a(i.$slots,"default")])])),a(i.$slots,"aside")]))}});export{I as _,T as a};