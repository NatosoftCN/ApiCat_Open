import{d as D,b4 as P,r as d,e as m,u as t,V as s,W as n,S as p,T as _,a1 as f,o as e,f as l,an as V,_ as v,Y as w}from"./vendor.1b70e788.js";import{y as E,v as S,z as h,w as b,S as j}from"./index.0747997f.js";import"./element-plus.33434d3d.js";const C={class:"flex flex-col border divide-y bg-white adwa"},B={class:"truncate"},T=D({setup(L){const x=P(),a=d([]),{isReader:u,isDeveloper:k,projectInfo:o}=E(),R=d({path:S({project_id:x.params.project_id})});return o&&(a.value=h,k&&(a.value=h.filter(c=>c.meta.role.indexOf(b.DEVELOPER)!==-1))),(c,O)=>{const i=f("router-link"),y=f("RouterView");return e(),m(_,null,[!t(u)&&t(o)?(e(),s(j,{key:0},{default:n(()=>[l("div",C,[(e(!0),m(_,null,V(a.value,r=>(e(),s(i,{key:r.name,to:{name:r.name},class:"relative h-12 pl-6 flex items-center text-neutral-600 hover:text-neutral-900"},{default:n(()=>[l("span",null,v(r.meta.title),1)]),_:2},1032,["to"]))),128)),w(i,{to:R.value,class:"relative h-12 pl-6 flex items-center text-blue-600"},{default:n(()=>[l("span",B,"\u524D\u5F80 "+v(t(o).name)+" \u6587\u6863",1)]),_:1},8,["to"])])]),_:1})):p("",!0),t(u)?(e(),s(y,{key:1})):p("",!0)],64)}}});export{T as default};
