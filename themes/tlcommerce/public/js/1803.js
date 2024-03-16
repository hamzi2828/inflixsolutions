"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[1803],{8782:(e,t,o)=>{o.d(t,{Z:()=>a});var n=o(821),r=(0,n.createElementVNode)("span",{class:"submenu-button ml-2"},[(0,n.createElementVNode)("i",{class:"fa fa-angle-down"})],-1),s={key:0,class:"submenu"};const l={name:"MenuDropdown",components:{MenuItem:o(4937).Z},props:{item:{type:Object,required:!0},openGroup:{type:Boolean,default:!1},headerMenuStyle:{type:Object,required:!1,default:function(){return{}}}},data:function(){return{isActive:!1,isOpen:!1,isShow:!1}},computed:{computedClass:function(){return this.isActive||this.isOpen}},watch:{$route:function(){this.openGroup?this.isActive=!0:this.isActive=!1}},mounted:function(){this.openGroup&&(this.isActive=!0,this.isShow=!0,this.isOpen=!0),window.innerWidth>991&&(this.isActive=!1,this.isShow=!0,this.isOpen=!1)},methods:{submenuClick:function(){this.isActive=!this.isActive,this.isOpen=!this.isOpen,this.isShow=!this.isShow}}};const a=(0,o(3744).Z)(l,[["render",function(e,t,o,l,a,c){var i=this,u=(0,n.resolveComponent)("router-link"),m=(0,n.resolveComponent)("menu-dropdown",!0),d=(0,n.resolveComponent)("menu-item");return(0,n.openBlock)(),(0,n.createElementBlock)("li",{class:(0,n.normalizeClass)([{"active-menu-parent":o.openGroup},{"menu-group-opened":a.isOpen}])},[(0,n.createVNode)(u,{to:o.item.url?o.item.url:"javascript:void(0);"},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("span",{class:(0,n.normalizeClass)(1==i.headerMenuStyle.custom_menu?"custom-menu":"")},(0,n.toDisplayString)(o.item.name),3),r]})),_:1},8,["to"]),(0,n.createElementVNode)("span",{class:(0,n.normalizeClass)(["submenu-button d-lg-none ml-2 d-inline-flex align-items-center justify-content-center",{open:c.computedClass}]),onClick:t[0]||(t[0]=function(){return c.submenuClick&&c.submenuClick.apply(c,arguments)})},[(0,n.createElementVNode)("i",{class:(0,n.normalizeClass)(["fa",c.computedClass?"fa-angle-up":"fa-angle-down"])},null,2)],2),a.isShow?((0,n.openBlock)(),(0,n.createElementBlock)("ul",s,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(o.item.submenu,(function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,null,[e.submenu&&e.submenu.length>0?((0,n.openBlock)(),(0,n.createBlock)(m,{key:"subitem-".concat(t),item:e,"open-group":o.openGroup,"header-menu-style":i.headerMenuStyle},null,8,["item","open-group","header-menu-style"])):((0,n.openBlock)(),(0,n.createBlock)(d,{key:"subitem-".concat(t),item:e,"header-menu-style":i.headerMenuStyle},null,8,["item","header-menu-style"]))],64)})),256))])):(0,n.createCommentVNode)("",!0)],2)}]])},4937:(e,t,o)=>{o.d(t,{Z:()=>m});var n=o(821),r=["href"],s={key:0},l={key:1},a=["href"],c={key:0},i={key:1};const u={name:"MenuItem",props:{item:{type:Object,required:!0},offCanvas:{type:Boolean,required:!1,default:!1},headerMenuStyle:{type:Object,required:!1,default:function(){return{}}}}};const m=(0,o(3744).Z)(u,[["render",function(e,t,o,u,m,d){return(0,n.openBlock)(),(0,n.createElementBlock)("li",null,[o.item.href?((0,n.openBlock)(),(0,n.createElementBlock)("a",{key:0,href:o.item.href,class:(0,n.normalizeClass)(1==this.headerMenuStyle.custom_menu?"custom-menu":"")},[o.offCanvas?((0,n.openBlock)(),(0,n.createElementBlock)("span",s,(0,n.toDisplayString)(e.$t(o.item.name)),1)):((0,n.openBlock)(),(0,n.createElementBlock)("span",l,(0,n.toDisplayString)(o.item.name),1))],10,r)):((0,n.openBlock)(),(0,n.createElementBlock)("a",{key:1,href:o.item.url},[(0,n.createElementVNode)("span",{class:(0,n.normalizeClass)(1==this.headerMenuStyle.custom_menu?"custom-menu":"")},[o.offCanvas?((0,n.openBlock)(),(0,n.createElementBlock)("span",c,(0,n.toDisplayString)(e.$t(o.item.name)),1)):((0,n.openBlock)(),(0,n.createElementBlock)("span",i,(0,n.toDisplayString)(o.item.name),1))],2)],8,a))])}]])},1803:(e,t,o)=>{o.r(t),o.d(t,{default:()=>A});var n=o(821),r={class:"custom-container2"},s={class:"row align-items-center justify-content-between"},l={key:0,class:"col-6"},a={key:1,class:"site-title"},c={key:1,class:"site-title"},i={key:1,class:"col-6"},u={key:1,class:"site-title"},m={key:1,class:"site-title"},d={class:"col-6 d-flex align-items-center justify-content-end position-static"},p={class:"count position-absolute d-flex align-items-center justify-content-center"};const h=JSON.parse('{"menuItems":[{"name":"Dashboard","href":"/dashboard"},{"name":"Purchase History","href":"/dashboard/purchase-history"},{"name":"Wishlist","href":"/dashboard/wishlist"},{"name":"Address","href":"/dashboard/address"},{"name":"Refund Requests","href":"/dashboard/refund/requests"},{"name":"My Wallet","href":"/dashboard/wallet"},{"name":"Manage Account","href":"/dashboard/manage-account"}]}');var f=o(903),y={class:"offcanvas-container d-flex"},k=[(0,n.createElementVNode)("span",{class:"bg-white"},null,-1),(0,n.createElementVNode)("span",{class:"bg-white"},null,-1),(0,n.createElementVNode)("span",{class:"bg-white"},null,-1)],g={key:0,class:"user-info"},v={class:"user-avatar mb-10"},b=["src","alt"],B={class:"mb-0"},S={key:1,class:"login-register mt-15"},E={href:"/login"},w=(0,n.createTextVNode)(" | "),C={href:"/register"},N={class:"offcanvas-content bg-white"},_={class:"offcanvas-menu"},V={class:"list-unstyled mb-0"};var O=o(4937),P=o(8782);const F={components:{MenuItem:O.Z,MenuDropdown:P.Z},props:{userInfo:{type:Object,default:null},menuItems:{type:Array,required:!0},headerMenuStyle:{type:Object,required:!1,default:function(){return{}}},headerStyle:{type:Object,required:!1,default:function(){return{}}}},data:function(){return{isOffcanvasOpened:!1}},computed:{isGroupActive:function(){return function(e,t){var o=!1;return function e(n){n.submenu&&n.submenu.forEach((function(n){t===n.url?o=!0:n.submenu&&e(n)}))}(e),o}}},methods:{toggleOffcanvas:function(){this.isOffcanvasOpened=!this.isOffcanvasOpened,document.body.classList.toggle("offcanvas-oppened")}}};var M=o(3744);const I=(0,M.Z)(F,[["render",function(e,t,o,r,s,l){var a=(0,n.resolveComponent)("base-icon-svg"),c=(0,n.resolveComponent)("menu-item"),i=(0,n.resolveComponent)("menu-dropdown");return(0,n.openBlock)(),(0,n.createElementBlock)("div",y,[(0,n.createElementVNode)("button",{class:(0,n.normalizeClass)(["hamburger",{active:s.isOffcanvasOpened}]),onClick:t[0]||(t[0]=function(){return l.toggleOffcanvas&&l.toggleOffcanvas.apply(l,arguments)})},k,2),(0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(["offcanvas-wrapper",{open:s.isOffcanvasOpened}])},[(0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(1==this.headerStyle.custom_header?"offcanvas-panel custom-offcanvas-panel w-100 h-100 bg-white":"offcanvas-panel w-100 h-100 bg-white")},[(0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(1==this.headerStyle.custom_header?"custom-offcanvas-header offcanvas-header position-relative":"offcanvas-header position-relative")},[(0,n.createElementVNode)("span",{class:"offcanvas-close d-inline-flex align-items-center justify-content-center position-absolute text-white",onClick:t[1]||(t[1]=function(){return l.toggleOffcanvas&&l.toggleOffcanvas.apply(l,arguments)})},[(0,n.createVNode)(a,{name:"close"})]),o.userInfo.name?((0,n.openBlock)(),(0,n.createElementBlock)("div",g,[(0,n.createElementVNode)("div",v,[(0,n.createElementVNode)("img",{class:"rounded-circle",src:o.userInfo.image,alt:o.userInfo.name,width:"70",height:"70"},null,8,b)]),(0,n.createElementVNode)("h4",B,(0,n.toDisplayString)(o.userInfo.name),1)])):((0,n.openBlock)(),(0,n.createElementBlock)("div",S,[(0,n.createElementVNode)("a",E,(0,n.toDisplayString)(e.$t("Login")),1),w,(0,n.createElementVNode)("a",C,(0,n.toDisplayString)(e.$t("Registration")),1)]))],2),(0,n.createElementVNode)("div",N,[(0,n.createElementVNode)("div",_,[(0,n.createElementVNode)("ul",V,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(o.menuItems,(function(t,r){return(0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,null,[t.submenu?((0,n.openBlock)(),(0,n.createBlock)(i,{key:"group-".concat(r),item:t,"off-canvas":"","open-group":l.isGroupActive(t,e.$route.fullPath),"header-menu-style":o.headerMenuStyle},null,8,["item","open-group","header-menu-style"])):((0,n.openBlock)(),(0,n.createBlock)(c,{key:"item-".concat(r),item:t,"off-canvas":"","header-menu-style":o.headerMenuStyle},null,8,["item","header-menu-style"]))],64)})),256))])])])],2)],2)])}]]);var D=o(3907);const j={name:"MobileHeader",components:{SearchForm:f.Z,TheOffcanvas:I},props:{siteProperties:{type:Object,required:!1},mode:{type:String,required:!1},cartItem:{type:Number,required:!1,default:0},headerStyle:{type:Object,required:!1,default:function(){return{}}},headerMenuStyle:{type:Object,required:!1,default:function(){return{}}},headerLogoStyle:{type:Object,required:!1,default:function(){return{}}}},data:function(){return{offcanvas:h,wishlistItem:0,compareItem:0,isSticky:!1}},computed:(0,D.rn)({customerInfo:function(e){return e.customerInfo}}),mounted:function(){window.addEventListener("scroll",this.scrollHandler)},methods:{scrollHandler:function(){var e=this.$refs.mobileHeader;window.pageYOffset>100?(this.isSticky=!0,e.classList.add("sticky","fadeInDowns")):(this.isSticky=!1,e.classList.remove("sticky","fadeInDowns"))}}},A=(0,M.Z)(j,[["render",function(e,t,o,h,f,y){var k=(0,n.resolveComponent)("the-logo"),g=(0,n.resolveComponent)("router-link"),v=(0,n.resolveComponent)("the-offcanvas"),b=(0,n.resolveComponent)("search-form"),B=(0,n.resolveComponent)("base-icon-svg");return(0,n.openBlock)(),(0,n.createElementBlock)("header",{class:(0,n.normalizeClass)(1==this.headerStyle.custom_header?" c1-bg custom-mobile-header mobile_header__two d-lg-none":"mobile_header__two d-lg-none c1-bg"),onScroll:t[0]||(t[0]=function(){return y.scrollHandler&&y.scrollHandler.apply(y,arguments)}),ref:"mobileHeader"},[(0,n.createElementVNode)("div",r,[(0,n.createElementVNode)("div",s,[f.isSticky?((0,n.openBlock)(),(0,n.createElementBlock)("div",i,["dark"==o.mode?((0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,{key:0},[o.siteProperties.sticky_black_mobile_logo?((0,n.openBlock)(),(0,n.createBlock)(k,{key:0,logo:o.siteProperties.sticky_black_mobile_logo,title:o.siteProperties.site_title,"header-logo-style":o.headerLogoStyle},null,8,["logo","title","header-logo-style"])):((0,n.openBlock)(),(0,n.createElementBlock)("h4",u,(0,n.toDisplayString)(o.siteProperties.site_title),1))],64)):((0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,{key:1},[o.siteProperties.sticky_mobile_logo?((0,n.openBlock)(),(0,n.createBlock)(k,{key:0,logo:o.siteProperties.sticky_mobile_logo,title:o.siteProperties.site_title,"header-logo-style":o.headerLogoStyle},null,8,["logo","title","header-logo-style"])):((0,n.openBlock)(),(0,n.createElementBlock)("h4",m,(0,n.toDisplayString)(o.siteProperties.site_title),1))],64))])):((0,n.openBlock)(),(0,n.createElementBlock)("div",l,["dark"==o.mode?((0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,{key:0},[o.siteProperties.mobile_dark_logo?((0,n.openBlock)(),(0,n.createBlock)(k,{key:0,logo:o.siteProperties.mobile_dark_logo,title:o.siteProperties.site_title,"header-logo-style":o.headerLogoStyle},null,8,["logo","title","header-logo-style"])):((0,n.openBlock)(),(0,n.createElementBlock)("h4",a,(0,n.toDisplayString)(o.siteProperties.site_title),1))],64)):((0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,{key:1},[o.siteProperties.mobile_logo?((0,n.openBlock)(),(0,n.createBlock)(k,{key:0,logo:o.siteProperties.mobile_logo,title:o.siteProperties.site_title,"header-logo-style":o.headerLogoStyle},null,8,["logo","title","header-logo-style"])):((0,n.openBlock)(),(0,n.createElementBlock)("h4",c,[(0,n.createVNode)(g,{to:"/"},{default:(0,n.withCtx)((function(){return[(0,n.createTextVNode)((0,n.toDisplayString)(o.siteProperties.site_title),1)]})),_:1})]))],64))])),(0,n.createElementVNode)("div",d,[(0,n.createVNode)(v,{"user-info":e.customerInfo,"menu-items":f.offcanvas.menuItems,"header-menu-style":o.headerMenuStyle,"header-style":o.headerStyle,class:"mr-20"},null,8,["user-info","menu-items","header-menu-style","header-style"]),(0,n.createVNode)(b,{"style-two":"","mobile-style":"",class:"mr-20"}),(0,n.createVNode)(g,{to:"/cart",class:"btn-circle custom-icon-btn"},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(B,{name:"cart",class:"material-icons",width:18,height:15}),(0,n.createElementVNode)("span",p,(0,n.toDisplayString)(o.cartItem),1)]})),_:1})])])])],34)}]])},903:(e,t,o)=>{o.d(t,{Z:()=>c});var n=o(821),r={class:"search-form-wrapper custom-search-btn-mobile"},s=["placeholder"],l=[(0,n.createElementVNode)("span",{class:"material-icons"}," search ",-1)];const a={name:"SearchForm",emits:["search-suggestions"],props:{rounded:{type:Boolean,default:!1},styleTwo:{type:Boolean,default:!1},styleThree:{type:Boolean,default:!1},styleFour:{type:Boolean,default:!1},mobileStyle:{type:Boolean,default:!1}},data:function(){return{searchFormActive:!1,searching_Key:""}},methods:{getSearchSuggestions:function(){this.$emit("search-suggestions",this.searching_Key)},searchProducts:function(){this.searchFormActive=!1,this.$router.push("/product/search?search_key="+this.searching_Key)},toggleSearchForm:function(){this.searchFormActive=!this.searchFormActive}}};const c=(0,o(3744).Z)(a,[["render",function(e,t,o,a,c,i){var u=(0,n.resolveComponent)("base-icon-svg");return(0,n.openBlock)(),(0,n.createElementBlock)("div",r,[o.mobileStyle?((0,n.openBlock)(),(0,n.createElementBlock)("button",{key:0,class:"p-0 bg-transparent border-0 text-white",onClick:t[0]||(t[0]=function(){return i.toggleSearchForm&&i.toggleSearchForm.apply(i,arguments)})},[(0,n.createVNode)(u,{name:"search",height:21,width:21})])):(0,n.createCommentVNode)("",!0),(0,n.createElementVNode)("form",{class:(0,n.normalizeClass)(["search-form",[o.mobileStyle?"mobile-search-form position-absolute w-100 h-100 d-flex align-items-center":"",{active:c.searchFormActive}]]),action:"#"},[o.mobileStyle?((0,n.openBlock)(),(0,n.createElementBlock)("button",{key:0,type:"button",class:"goback border-0 mr-20 d-inline-flex align-items-center justify-content-center",onClick:t[1]||(t[1]=function(){return i.toggleSearchForm&&i.toggleSearchForm.apply(i,arguments)})},[(0,n.createVNode)(u,{name:"undo",height:20,width:20})])):(0,n.createCommentVNode)("",!0),(0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(["input-group",[{"style--rounded":o.rounded},{"style--two":o.styleTwo},{"style--three":o.styleThree},{"style--four":o.styleFour}]])},[(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"text",placeholder:e.$t("Enter your search key"),class:"form-control","onUpdate:modelValue":t[2]||(t[2]=function(e){return c.searching_Key=e}),onKeyup:t[3]||(t[3]=function(){return i.getSearchSuggestions&&i.getSearchSuggestions.apply(i,arguments)})},null,40,s),[[n.vModelText,c.searching_Key]]),o.styleFour?((0,n.openBlock)(),(0,n.createElementBlock)("button",{key:1,type:"submit",class:"search-icon-btn",onClick:t[5]||(t[5]=(0,n.withModifiers)((function(){return i.searchProducts&&i.searchProducts.apply(i,arguments)}),["prevent"]))},l)):((0,n.openBlock)(),(0,n.createElementBlock)("button",{key:0,type:"submit",class:"btn btn_fill custom-search-btn",onClick:t[4]||(t[4]=(0,n.withModifiers)((function(){return i.searchProducts&&i.searchProducts.apply(i,arguments)}),["prevent"]))},(0,n.toDisplayString)(e.$t("Search")),1))],2)],2)])}]])}}]);