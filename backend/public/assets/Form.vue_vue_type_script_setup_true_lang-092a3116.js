import{z as t,j as i,o as n,c as r,a as p,b as a,ao as m,m as u}from"./multiselect-82d1182f.js";import{_ as s}from"./index-5e60d8d5.js";import{_ as f}from"./Tag.vue_vue_type_script_setup_true_lang-85406545.js";const V={class:"w-full flex justify-center min-h-screen"},b={class:"w-1/2"},w={key:0},_=t({__name:"Form",props:{form:{},roles:{},isEdit:{type:Boolean}},setup(y){const d=i(()=>["admin","user"]);return(e,o)=>(n(),r("div",V,[p("div",b,[a(m(s),{name:"name",modelValue:e.form.name,"onUpdate:modelValue":o[0]||(o[0]=l=>e.form.name=l),label:"Meno",class:"mb-3"},null,8,["modelValue"]),a(m(s),{name:"email",modelValue:e.form.email,"onUpdate:modelValue":o[1]||(o[1]=l=>e.form.email=l),label:"Email",type:"email",class:"mb-3"},null,8,["modelValue"]),a(m(s),{name:"password",modelValue:e.form.password,"onUpdate:modelValue":o[2]||(o[2]=l=>e.form.password=l),type:"password",label:"Heslo",class:"mb-3"},null,8,["modelValue"]),e.isEdit?(n(),r("p",w,"Ponechajte prázdne heslo sa nezmení")):u("",!0),a(m(f),{name:"role",options:d.value,label:"Rola",mode:"single",modelValue:e.form.role,"onUpdate:modelValue":o[3]||(o[3]=l=>e.form.role=l)},null,8,["options","modelValue"])])]))}});export{_};