import{g as _,f as m}from"./element-plus.33434d3d.js";import{b as d,ag as p,ab as s,_ as f}from"./index.0747997f.js";import{_ as u}from"./img_join.8db8ddd5.js";import{q as h,o as g,e as k,f as e,Y as i,W as j,ab as C}from"./vendor.1b70e788.js";const y={name:"ProjectVerification",inject:["showHeader"],data(){return{isLoading:!1,form:{project_id:this.$route.params.project_id||"",secret_key:""}}},methods:{onSubmitBtnClick(){this.isLoading=!0,p(this.form).then(t=>{s.set(s.KEYS.SECRET_PROJECT_TOKEN+this.form.project_id,t.data||"",!0),location.href=`/app/${this.form.project_id}`}).finally(()=>{this.isLoading=!1})}},setup(){h("showHeader")(!1)}},E={class:"ac-verification"},V={class:"ac-verification__main"},b=e("span",{class:"logo large"},[e("img",{src:f,alt:"ApiCat"}),e("span",{class:"logo-text logo-apicat mt-0"},"ApiCat")],-1),w=C("\u7EE7\u7EED\u8BBF\u95EE"),x=e("img",{src:u,class:"mt-5 w-full"},null,-1);function B(t,a,S,v,o,r){const c=_,n=m;return g(),k("main",E,[e("div",V,[b,i(c,{class:"my-7 w-1/2",modelValue:o.form.secret_key,"onUpdate:modelValue":a[0]||(a[0]=l=>o.form.secret_key=l),placeholder:"\u8BBF\u95EE\u5BC6\u7801",maxlength:"6",clearable:""},null,8,["modelValue"]),i(n,{loading:o.isLoading,type:"primary",onClick:r.onSubmitBtnClick},{default:j(()=>[w]),_:1},8,["loading","onClick"]),x])])}var T=d(y,[["render",B]]);export{T as default};