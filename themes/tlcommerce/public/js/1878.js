"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[1878],{6646:(e,t,r)=>{r.d(t,{Z:()=>n});var o=r(3645),i=r.n(o)()((function(e){return e[1]}));i.push([e.id,".category-section[data-v-2fd09c8c]{background-color:var(--section-background-color);background-image:var(--section-bg-image);background-position:var(--section-background-image-position);background-repeat:var(--section-background-image-repeat);background-size:var(--section-background-image-size);margin:var(--section-margin)!important;padding:var(--section-padding)!important}",""]);const n=i},1878:(e,t,r)=>{r.r(t),r.d(t,{default:()=>u});var o=r(821),i={class:"px-3 px-sm-0"};var n=r(2830),a=r(1911),s=(0,o.defineAsyncComponent)((function(){return r.e(6705).then(r.bind(r,6705))}));r(9669).default;const c={name:"CategorySection",components:{CategoryCard:s,Swiper:n.tq,SwiperSlide:n.o5},setup:function(){return{modules:[a.pt,a.tl]}},props:{content:{type:String,required:!1},properties:{type:Array,required:!1}},computed:{styleObject:function(){return{"--section-background-color":this.properties.bg_color,"--section-bg-image":"url(".concat(this.properties.bg_image,")"),"--section-background-image-position":this.properties.background_position,"--section-background-image-size":this.properties.background_size,"--section-background-image-repeat":this.properties.background_repeat,"--section-padding":"".concat(this.properties.padding_top+"px "+this.properties.padding_right+"px "+this.properties.padding_bottom+"px "+this.properties.padding_left+"px"),"--section-margin":"".concat(this.properties.margin_top+"px "+this.properties.margin_right+"px "+this.properties.margin_bottom+"px "+this.properties.margin_left+"px")}}}};var p=r(3379),d=r.n(p),l=r(6646),g={insert:"head",singleton:!1};d()(l.Z,g);l.Z.locals;const u=(0,r(3744).Z)(c,[["render",function(e,t,r,n,a,s){var c=(0,o.resolveComponent)("category-card"),p=(0,o.resolveComponent)("swiper-slide"),d=(0,o.resolveComponent)("swiper");return(0,o.openBlock)(),(0,o.createElementBlock)("section",{class:"pt-15 pb-15 category-section bg-white",style:(0,o.normalizeStyle)(s.styleObject)},[(0,o.createElementVNode)("div",i,[r.properties.categories.data.length?((0,o.openBlock)(),(0,o.createBlock)(d,{key:0,modules:n.modules,loop:!0,centeredSlides:!0,autoplay:{delay:2500},pagination:{clickable:!0},class:"category-slider category-full-width theme-slider-dots",breakpoints:{0:{slidesPerView:2,spaceBetween:16},768:{slidesPerView:3,spaceBetween:20},1024:{slidesPerView:4,spaceBetween:20},1440:{slidesPerView:5,spaceBetween:20}}},{default:(0,o.withCtx)((function(){return[((0,o.openBlock)(!0),(0,o.createElementBlock)(o.Fragment,null,(0,o.renderList)(r.properties.categories.data,(function(e,t){return(0,o.openBlock)(),(0,o.createBlock)(p,{key:"category-".concat(t)},{default:(0,o.withCtx)((function(){return[(0,o.createVNode)(c,{cat:e},null,8,["cat"])]})),_:2},1024)})),128))]})),_:1},8,["modules"])):(0,o.createCommentVNode)("",!0)])],4)}],["__scopeId","data-v-2fd09c8c"]])}}]);