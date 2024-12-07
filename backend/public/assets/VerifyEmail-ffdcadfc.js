import{z as _,j as h,r as v,bV as g,o as i,c as l,b as a,ao as t,k,a as o,t as s,x as b,w as n,d as r,m as w,p as x}from"./multiselect-82d1182f.js";import{T as V,Z as $,a as B}from"./index-5e60d8d5.js";import{_ as C}from"./Alert.vue_vue_type_script_setup_true_lang-8e316541.js";const L={class:"bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10"},N={class:"mb-6 text-center text-sm text-gray-600"},j={class:"flex justify-center"},z=_({__name:"VerifyEmail",props:{status:{}},setup(d){const m=d,c=V({}),u=()=>{c.post(route("verification.send"))},f=h(()=>m.status==="verification-link-sent");return(e,D)=>{const p=v("Link"),y=g("auto-animate");return i(),l("div",null,[a(t($),{title:e.$t("Verify e-mail")},null,8,["title"]),k((i(),l("div",L,[o("p",N,s(e.$t("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.")),1),f.value?(i(),b(t(C),{key:0,type:"success",class:"mb-6"},{default:n(()=>[r(s(e.$t("A new verification link has been sent to the email address you provided during registration.")),1)]),_:1})):w("",!0),o("form",{class:"space-y-6",onSubmit:x(u,["prevent"])},[a(t(B),{class:"w-full",type:"submit",disabled:t(c).processing},{default:n(()=>[r(s(e.$t("Resend Verification Email")),1)]),_:1},8,["disabled"]),o("div",j,[a(p,{href:"/admin/logout",method:"post",class:"text-sm font-medium text-primary-600 hover:text-primary-500"},{default:n(()=>[r(s(e.$t("Log Out")),1)]),_:1})])],32)])),[[y]])])}}});export{z as default};
