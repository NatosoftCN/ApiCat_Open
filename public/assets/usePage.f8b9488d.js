import{b4 as t,aY as o,r as n,v as p}from"./vendor.1b70e788.js";const m=a=>{const s=t(),u=o(),r=parseInt(s.query.page,10),e=n(isNaN(r)?1:r);return p(()=>e.value,()=>{u.push({name:u.currentRoute.value.name,query:{page:e.value}}),a&&a()}),{page:e}};export{m as u};