import{z as g,A as p,S as P,D as k,C as d,F as h,G as K,j as D,H as S,Q as m,T as C,U as $,J as M,V as H,Z as U,$ as I,i as w,a0 as v}from"./multiselect-82d1182f.js";var A=(l=>(l[l.Open=0]="Open",l[l.Closed=1]="Closed",l))(A||{});let E=Symbol("DisclosureContext");function O(l){let o=w(E,null);if(o===null){let r=new Error(`<${l} /> is missing a parent <Disclosure /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(r,O),r}return o}let B=Symbol("DisclosurePanelContext");function L(){return w(B,null)}let Q=g({name:"Disclosure",props:{as:{type:[Object,String],default:"template"},defaultOpen:{type:[Boolean],default:!1}},setup(l,{slots:o,attrs:r}){let n=p(l.defaultOpen?0:1),e=p(null),i=p(null),s={buttonId:p(`headlessui-disclosure-button-${P()}`),panelId:p(`headlessui-disclosure-panel-${P()}`),disclosureState:n,panel:e,button:i,toggleDisclosure(){n.value=k(n.value,{0:1,1:0})},closeDisclosure(){n.value!==1&&(n.value=1)},close(t){s.closeDisclosure();let u=(()=>t?t instanceof HTMLElement?t:t.value instanceof HTMLElement?d(t):d(s.button):d(s.button))();u==null||u.focus()}};return h(E,s),K(D(()=>k(n.value,{0:S.Open,1:S.Closed}))),()=>{let{defaultOpen:t,...u}=l,c={open:n.value===0,close:s.close};return m({theirProps:u,ourProps:{},slot:c,slots:o,attrs:r,name:"Disclosure"})}}}),V=g({name:"DisclosureButton",props:{as:{type:[Object,String],default:"button"},disabled:{type:[Boolean],default:!1},id:{type:String,default:null}},setup(l,{attrs:o,slots:r,expose:n}){let e=O("DisclosureButton"),i=L(),s=D(()=>i===null?!1:i.value===e.panelId.value);C(()=>{s.value||l.id!==null&&(e.buttonId.value=l.id)}),$(()=>{s.value||(e.buttonId.value=null)});let t=p(null);n({el:t,$el:t}),s.value||M(()=>{e.button.value=t.value});let u=H(D(()=>({as:l.as,type:o.type})),t);function c(){var a;l.disabled||(s.value?(e.toggleDisclosure(),(a=d(e.button))==null||a.focus()):e.toggleDisclosure())}function f(a){var b;if(!l.disabled)if(s.value)switch(a.key){case v.Space:case v.Enter:a.preventDefault(),a.stopPropagation(),e.toggleDisclosure(),(b=d(e.button))==null||b.focus();break}else switch(a.key){case v.Space:case v.Enter:a.preventDefault(),a.stopPropagation(),e.toggleDisclosure();break}}function y(a){switch(a.key){case v.Space:a.preventDefault();break}}return()=>{var a;let b={open:e.disclosureState.value===0},{id:x,...T}=l,j=s.value?{ref:t,type:u.value,onClick:c,onKeydown:f}:{id:(a=e.buttonId.value)!=null?a:x,ref:t,type:u.value,"aria-expanded":e.disclosureState.value===0,"aria-controls":e.disclosureState.value===0||d(e.panel)?e.panelId.value:void 0,disabled:l.disabled?!0:void 0,onClick:c,onKeydown:f,onKeyup:y};return m({ourProps:j,theirProps:T,slot:b,attrs:o,slots:r,name:"DisclosureButton"})}}}),z=g({name:"DisclosurePanel",props:{as:{type:[Object,String],default:"div"},static:{type:Boolean,default:!1},unmount:{type:Boolean,default:!0},id:{type:String,default:null}},setup(l,{attrs:o,slots:r,expose:n}){let e=O("DisclosurePanel");C(()=>{l.id!==null&&(e.panelId.value=l.id)}),$(()=>{e.panelId.value=null}),n({el:e.panel,$el:e.panel}),h(B,e.panelId);let i=U(),s=D(()=>i!==null?(i.value&S.Open)===S.Open:e.disclosureState.value===0);return()=>{var t;let u={open:e.disclosureState.value===0,close:e.close},{id:c,...f}=l,y={id:(t=e.panelId.value)!=null?t:c,ref:e.panel};return m({ourProps:y,theirProps:f,slot:u,attrs:o,slots:r,features:I.RenderStrategy|I.Static,visible:s.value,name:"DisclosurePanel"})}}});export{Q as N,V as Q,z as V};
