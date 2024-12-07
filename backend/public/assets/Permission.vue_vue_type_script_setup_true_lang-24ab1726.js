import{z as F,bV as N,k as b,o as m,x as _,w as d,b as c,ao as l,e as V,n as $,a as w,s as P,au as O,j as B,r as D,c as h,a5 as M,R as x,t as j}from"./multiselect-82d1182f.js";import{s as y,v as A,w as E,x as T,b as U,t as S}from"./index-5e60d8d5.js";import{Q as z,V as k,N as G}from"./disclosure-3a0c664b.js";import{_ as C}from"./_baseIteratee-5808ab78.js";const Q=F({__name:"Accordion",props:{defaultOpen:{type:Boolean,default:!1}},setup(e){return(t,n)=>{const s=N("auto-animate");return b((m(),_(l(G),{as:"div",defaultOpen:t.defaultOpen},{default:d(({open:a})=>[c(l(z),{class:"group flex w-full items-center justify-between px-4 py-3 text-left font-medium leading-8 text-gray-900 focus:outline-none focus-visible:ring focus-visible:ring-primary-500 focus-visible:ring-opacity-75"},{default:d(()=>[V(t.$slots,"title"),c(l(y),{class:$([{"rotate-180 transform":a},"h-5 w-5 text-gray-400 group-hover:text-gray-700"])},null,8,["class"])]),_:2},1024),b(w("div",null,[c(l(k),{class:"p-4 pt-1 text-gray-700",static:""},{default:d(()=>[V(t.$slots,"content")]),_:3})],512),[[P,a]])]),_:3},8,["defaultOpen"])),[[s]])}}});var R=C,X=A,Y=E;function q(e){return function(t,n,s){var a=Object(t);if(!X(t)){var r=R(n);t=Y(t),n=function(p){return r(a[p],p,a)}}var u=e(t,n,s);return u>-1?a[r?t[u]:u]:void 0}}var H=q;function J(e,t,n,s){for(var a=e.length,r=n+(s?1:-1);s?r--:++r<a;)if(t(e[r],r,e))return r;return-1}var K=J,W=T,I=1/0,Z=17976931348623157e292;function ee(e){if(!e)return e===0?e:0;if(e=W(e),e===I||e===-I){var t=e<0?-1:1;return t*Z}return e===e?e:0}var te=ee,ne=te;function ae(e){var t=ne(e),n=t%1;return t===t?n?t-n:t:0}var re=ae,se=K,ie=C,oe=re,le=Math.max,ue=Math.min;function me(e,t,n){var s=e==null?0:e.length;if(!s)return-1;var a=s-1;return n!==void 0&&(a=oe(n),a=n<0?le(s+a,0):ue(a,s-1)),se(e,ie(t),a,!0)}var de=me,pe=H,fe=de,ce=pe(fe),ve=ce;const _e=O(ve),xe=F({__name:"Permission",props:{modelValue:{},parentPermission:{},defaultOpen:{type:Boolean}},emits:["update:modelValue"],setup(e,{emit:t}){const n=e,s=t,a=B({get:()=>n.modelValue,set:i=>{s("update:modelValue",i)}}),r=i=>n.parentPermission?n.parentPermission+"."+i:i,u=()=>n.parentPermission?"text-sm":"text-lg",p=i=>{if(i.search("role")===0&&!confirm(S("mycustomadmin","Do you really want to revoke permission to manage permissions?"))){const v=_e(i.split("."));n.modelValue[v]=!n.modelValue[v],s("update:modelValue",n.modelValue)}};return(i,v)=>{const L=D("Permission",!0);return m(!0),h(x,null,M(a.value,(g,o)=>(m(),h(x,null,[typeof g!="boolean"?(m(),_(l(Q),{key:0,"default-open":i.defaultOpen},{title:d(()=>[w("span",{class:$(u())},j(i.$t("permissions",r(o))),3)]),content:d(()=>[c(L,{"default-open":!1,modelValue:a.value[o],"onUpdate:modelValue":f=>a.value[o]=f,"parent-permission":r(o)},null,8,["modelValue","onUpdate:modelValue","parent-permission"])]),_:2},1032,["default-open"])):(m(),_(l(U),{modelValue:a.value[o],"onUpdate:modelValue":f=>a.value[o]=f,key:r(o),name:r(o),label:i.$t("permissions",r(o)),value:o,checked:g,onChange:f=>p(r(o))},null,8,["modelValue","onUpdate:modelValue","name","label","value","checked","onChange"]))],64))),256)}}});export{xe as _};