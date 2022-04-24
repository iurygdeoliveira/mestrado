/**
 * Minified by jsDelivr using Terser v5.10.0.
 * Original file: /npm/appwrite@7.0.0/dist/iife/sdk.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
!function(e,t,i){"use strict";
/*! *****************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */function n(e,t,i,n){return new(i||(i=Promise))((function(o,s){function r(e){try{d(n.next(e))}catch(e){s(e)}}function a(e){try{d(n.throw(e))}catch(e){s(e)}}function d(e){var t;e.done?o(e.value):(t=e.value,t instanceof i?t:new i((function(e){e(t)}))).then(r,a)}d((n=n.apply(e,t||[])).next())}))}class o extends Error{constructor(e,t=0,i="",n=""){super(e),this.name="AppwriteException",this.message=e,this.code=t,this.type=i,this.response=n}}class s{constructor(){this.config={endpoint:"https://HOSTNAME/v1",endpointRealtime:"",project:"",jwt:"",locale:""},this.headers={"x-sdk-version":"appwrite:web:7.0.0","X-Appwrite-Response-Format":"0.13.0"},this.realtime={socket:void 0,timeout:void 0,url:"",channels:new Set,subscriptions:new Map,subscriptionsCounter:0,reconnect:!0,reconnectAttempts:0,lastMessage:void 0,connect:()=>{clearTimeout(this.realtime.timeout),this.realtime.timeout=null===window||void 0===window?void 0:window.setTimeout((()=>{this.realtime.createSocket()}),50)},getTimeout:()=>{switch(!0){case this.realtime.reconnectAttempts<5:return 1e3;case this.realtime.reconnectAttempts<15:return 5e3;case this.realtime.reconnectAttempts<100:return 1e4;default:return 6e4}},createSocket:()=>{var e,t;if(this.realtime.channels.size<1)return;const i=new URLSearchParams;i.set("project",this.config.project),this.realtime.channels.forEach((e=>{i.append("channels[]",e)}));const n=this.config.endpointRealtime+"/realtime?"+i.toString();(n!==this.realtime.url||!this.realtime.socket||(null===(e=this.realtime.socket)||void 0===e?void 0:e.readyState)>WebSocket.OPEN)&&(this.realtime.socket&&(null===(t=this.realtime.socket)||void 0===t?void 0:t.readyState)<WebSocket.CLOSING&&(this.realtime.reconnect=!1,this.realtime.socket.close()),this.realtime.url=n,this.realtime.socket=new WebSocket(n),this.realtime.socket.addEventListener("message",this.realtime.onMessage),this.realtime.socket.addEventListener("open",(e=>{this.realtime.reconnectAttempts=0})),this.realtime.socket.addEventListener("close",(e=>{var t,i,n;if(!this.realtime.reconnect||"error"===(null===(i=null===(t=this.realtime)||void 0===t?void 0:t.lastMessage)||void 0===i?void 0:i.type)&&1008===(null===(n=this.realtime)||void 0===n?void 0:n.lastMessage.data).code)return void(this.realtime.reconnect=!0);const o=this.realtime.getTimeout();console.error(`Realtime got disconnected. Reconnect will be attempted in ${o/1e3} seconds.`,e.reason),setTimeout((()=>{this.realtime.reconnectAttempts++,this.realtime.createSocket()}),o)})))},onMessage:e=>{var t,i;try{const n=JSON.parse(e.data);switch(this.realtime.lastMessage=n,n.type){case"connected":const e=JSON.parse(null!==(t=window.localStorage.getItem("cookieFallback"))&&void 0!==t?t:"{}"),o=null==e?void 0:e[`a_session_${this.config.project}`],s=n.data;o&&!s.user&&(null===(i=this.realtime.socket)||void 0===i||i.send(JSON.stringify({type:"authentication",data:{session:o}})));break;case"event":let r=n.data;if(null==r?void 0:r.channels){if(!r.channels.some((e=>this.realtime.channels.has(e))))return;this.realtime.subscriptions.forEach((e=>{r.channels.some((t=>e.channels.includes(t)))&&setTimeout((()=>e.callback(r)))}))}break;case"error":throw n.data}}catch(e){console.error(e)}},cleanUp:e=>{this.realtime.channels.forEach((t=>{if(e.includes(t)){Array.from(this.realtime.subscriptions).some((([e,i])=>i.channels.includes(t)))||this.realtime.channels.delete(t)}}))}},this.account={get:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account");return yield this.call("get",e,{"content-type":"application/json"},{})})),create:(e,t,i,s)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "userId"');if(void 0===t)throw new o('Missing required parameter: "email"');if(void 0===i)throw new o('Missing required parameter: "password"');let n={};void 0!==e&&(n.userId=e),void 0!==t&&(n.email=t),void 0!==i&&(n.password=i),void 0!==s&&(n.name=s);const r=new URL(this.config.endpoint+"/account");return yield this.call("post",r,{"content-type":"application/json"},n)})),delete:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account");return yield this.call("delete",e,{"content-type":"application/json"},{})})),updateEmail:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "email"');if(void 0===t)throw new o('Missing required parameter: "password"');let i={};void 0!==e&&(i.email=e),void 0!==t&&(i.password=t);const n=new URL(this.config.endpoint+"/account/email");return yield this.call("patch",n,{"content-type":"application/json"},i)})),createJWT:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account/jwt");return yield this.call("post",e,{"content-type":"application/json"},{})})),getLogs:(e,t)=>n(this,void 0,void 0,(function*(){let i={};void 0!==e&&(i.limit=e),void 0!==t&&(i.offset=t);const n=new URL(this.config.endpoint+"/account/logs");return yield this.call("get",n,{"content-type":"application/json"},i)})),updateName:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "name"');let t={};void 0!==e&&(t.name=e);const i=new URL(this.config.endpoint+"/account/name");return yield this.call("patch",i,{"content-type":"application/json"},t)})),updatePassword:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "password"');let i={};void 0!==e&&(i.password=e),void 0!==t&&(i.oldPassword=t);const n=new URL(this.config.endpoint+"/account/password");return yield this.call("patch",n,{"content-type":"application/json"},i)})),getPrefs:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account/prefs");return yield this.call("get",e,{"content-type":"application/json"},{})})),updatePrefs:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "prefs"');let t={};void 0!==e&&(t.prefs=e);const i=new URL(this.config.endpoint+"/account/prefs");return yield this.call("patch",i,{"content-type":"application/json"},t)})),createRecovery:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "email"');if(void 0===t)throw new o('Missing required parameter: "url"');let i={};void 0!==e&&(i.email=e),void 0!==t&&(i.url=t);const n=new URL(this.config.endpoint+"/account/recovery");return yield this.call("post",n,{"content-type":"application/json"},i)})),updateRecovery:(e,t,i,s)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "userId"');if(void 0===t)throw new o('Missing required parameter: "secret"');if(void 0===i)throw new o('Missing required parameter: "password"');if(void 0===s)throw new o('Missing required parameter: "passwordAgain"');let n={};void 0!==e&&(n.userId=e),void 0!==t&&(n.secret=t),void 0!==i&&(n.password=i),void 0!==s&&(n.passwordAgain=s);const r=new URL(this.config.endpoint+"/account/recovery");return yield this.call("put",r,{"content-type":"application/json"},n)})),getSessions:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account/sessions");return yield this.call("get",e,{"content-type":"application/json"},{})})),createSession:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "email"');if(void 0===t)throw new o('Missing required parameter: "password"');let i={};void 0!==e&&(i.email=e),void 0!==t&&(i.password=t);const n=new URL(this.config.endpoint+"/account/sessions");return yield this.call("post",n,{"content-type":"application/json"},i)})),deleteSessions:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account/sessions");return yield this.call("delete",e,{"content-type":"application/json"},{})})),createAnonymousSession:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/account/sessions/anonymous");return yield this.call("post",e,{"content-type":"application/json"},{})})),createMagicURLSession:(e,t,i)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "userId"');if(void 0===t)throw new o('Missing required parameter: "email"');let n={};void 0!==e&&(n.userId=e),void 0!==t&&(n.email=t),void 0!==i&&(n.url=i);const s=new URL(this.config.endpoint+"/account/sessions/magic-url");return yield this.call("post",s,{"content-type":"application/json"},n)})),updateMagicURLSession:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "userId"');if(void 0===t)throw new o('Missing required parameter: "secret"');let i={};void 0!==e&&(i.userId=e),void 0!==t&&(i.secret=t);const n=new URL(this.config.endpoint+"/account/sessions/magic-url");return yield this.call("put",n,{"content-type":"application/json"},i)})),createOAuth2Session:(e,t,i,n)=>{if(void 0===e)throw new o('Missing required parameter: "provider"');let s="/account/sessions/oauth2/{provider}".replace("{provider}",e),r={};void 0!==t&&(r.success=t),void 0!==i&&(r.failure=i),void 0!==n&&(r.scopes=n);const a=new URL(this.config.endpoint+s);r.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(r)))a.searchParams.append(e,t);if("undefined"==typeof window||!(null===window||void 0===window?void 0:window.location))return a;window.location.href=a.toString()},getSession:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "sessionId"');let t="/account/sessions/{sessionId}".replace("{sessionId}",e);const i=new URL(this.config.endpoint+t);return yield this.call("get",i,{"content-type":"application/json"},{})})),updateSession:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "sessionId"');let t="/account/sessions/{sessionId}".replace("{sessionId}",e);const i=new URL(this.config.endpoint+t);return yield this.call("patch",i,{"content-type":"application/json"},{})})),deleteSession:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "sessionId"');let t="/account/sessions/{sessionId}".replace("{sessionId}",e);const i=new URL(this.config.endpoint+t);return yield this.call("delete",i,{"content-type":"application/json"},{})})),createVerification:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "url"');let t={};void 0!==e&&(t.url=e);const i=new URL(this.config.endpoint+"/account/verification");return yield this.call("post",i,{"content-type":"application/json"},t)})),updateVerification:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "userId"');if(void 0===t)throw new o('Missing required parameter: "secret"');let i={};void 0!==e&&(i.userId=e),void 0!==t&&(i.secret=t);const n=new URL(this.config.endpoint+"/account/verification");return yield this.call("put",n,{"content-type":"application/json"},i)}))},this.avatars={getBrowser:(e,t,i,n)=>{if(void 0===e)throw new o('Missing required parameter: "code"');let s="/avatars/browsers/{code}".replace("{code}",e),r={};void 0!==t&&(r.width=t),void 0!==i&&(r.height=i),void 0!==n&&(r.quality=n);const a=new URL(this.config.endpoint+s);r.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(r)))a.searchParams.append(e,t);return a},getCreditCard:(e,t,i,n)=>{if(void 0===e)throw new o('Missing required parameter: "code"');let s="/avatars/credit-cards/{code}".replace("{code}",e),r={};void 0!==t&&(r.width=t),void 0!==i&&(r.height=i),void 0!==n&&(r.quality=n);const a=new URL(this.config.endpoint+s);r.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(r)))a.searchParams.append(e,t);return a},getFavicon:e=>{if(void 0===e)throw new o('Missing required parameter: "url"');let t={};void 0!==e&&(t.url=e);const i=new URL(this.config.endpoint+"/avatars/favicon");t.project=this.config.project;for(const[e,n]of Object.entries(this.flatten(t)))i.searchParams.append(e,n);return i},getFlag:(e,t,i,n)=>{if(void 0===e)throw new o('Missing required parameter: "code"');let s="/avatars/flags/{code}".replace("{code}",e),r={};void 0!==t&&(r.width=t),void 0!==i&&(r.height=i),void 0!==n&&(r.quality=n);const a=new URL(this.config.endpoint+s);r.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(r)))a.searchParams.append(e,t);return a},getImage:(e,t,i)=>{if(void 0===e)throw new o('Missing required parameter: "url"');let n={};void 0!==e&&(n.url=e),void 0!==t&&(n.width=t),void 0!==i&&(n.height=i);const s=new URL(this.config.endpoint+"/avatars/image");n.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(n)))s.searchParams.append(e,t);return s},getInitials:(e,t,i,n,o)=>{let s={};void 0!==e&&(s.name=e),void 0!==t&&(s.width=t),void 0!==i&&(s.height=i),void 0!==n&&(s.color=n),void 0!==o&&(s.background=o);const r=new URL(this.config.endpoint+"/avatars/initials");s.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(s)))r.searchParams.append(e,t);return r},getQR:(e,t,i,n)=>{if(void 0===e)throw new o('Missing required parameter: "text"');let s={};void 0!==e&&(s.text=e),void 0!==t&&(s.size=t),void 0!==i&&(s.margin=i),void 0!==n&&(s.download=n);const r=new URL(this.config.endpoint+"/avatars/qr");s.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(s)))r.searchParams.append(e,t);return r}},this.database={listDocuments:(e,t,i,s,r,a,d,c)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "collectionId"');let n="/database/collections/{collectionId}/documents".replace("{collectionId}",e),l={};void 0!==t&&(l.queries=t),void 0!==i&&(l.limit=i),void 0!==s&&(l.offset=s),void 0!==r&&(l.cursor=r),void 0!==a&&(l.cursorDirection=a),void 0!==d&&(l.orderAttributes=d),void 0!==c&&(l.orderTypes=c);const p=new URL(this.config.endpoint+n);return yield this.call("get",p,{"content-type":"application/json"},l)})),createDocument:(e,t,i,s,r)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "collectionId"');if(void 0===t)throw new o('Missing required parameter: "documentId"');if(void 0===i)throw new o('Missing required parameter: "data"');let n="/database/collections/{collectionId}/documents".replace("{collectionId}",e),a={};void 0!==t&&(a.documentId=t),void 0!==i&&(a.data=i),void 0!==s&&(a.read=s),void 0!==r&&(a.write=r);const d=new URL(this.config.endpoint+n);return yield this.call("post",d,{"content-type":"application/json"},a)})),getDocument:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "collectionId"');if(void 0===t)throw new o('Missing required parameter: "documentId"');let i="/database/collections/{collectionId}/documents/{documentId}".replace("{collectionId}",e).replace("{documentId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("get",n,{"content-type":"application/json"},{})})),updateDocument:(e,t,i,s,r)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "collectionId"');if(void 0===t)throw new o('Missing required parameter: "documentId"');if(void 0===i)throw new o('Missing required parameter: "data"');let n="/database/collections/{collectionId}/documents/{documentId}".replace("{collectionId}",e).replace("{documentId}",t),a={};void 0!==i&&(a.data=i),void 0!==s&&(a.read=s),void 0!==r&&(a.write=r);const d=new URL(this.config.endpoint+n);return yield this.call("patch",d,{"content-type":"application/json"},a)})),deleteDocument:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "collectionId"');if(void 0===t)throw new o('Missing required parameter: "documentId"');let i="/database/collections/{collectionId}/documents/{documentId}".replace("{collectionId}",e).replace("{documentId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("delete",n,{"content-type":"application/json"},{})}))},this.functions={retryBuild:(e,t,i)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "functionId"');if(void 0===t)throw new o('Missing required parameter: "deploymentId"');if(void 0===i)throw new o('Missing required parameter: "buildId"');let n="/functions/{functionId}/deployments/{deploymentId}/builds/{buildId}".replace("{functionId}",e).replace("{deploymentId}",t).replace("{buildId}",i);const s=new URL(this.config.endpoint+n);return yield this.call("post",s,{"content-type":"application/json"},{})})),listExecutions:(e,t,i,s,r,a)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "functionId"');let n="/functions/{functionId}/executions".replace("{functionId}",e),d={};void 0!==t&&(d.limit=t),void 0!==i&&(d.offset=i),void 0!==s&&(d.search=s),void 0!==r&&(d.cursor=r),void 0!==a&&(d.cursorDirection=a);const c=new URL(this.config.endpoint+n);return yield this.call("get",c,{"content-type":"application/json"},d)})),createExecution:(e,t,i)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "functionId"');let n="/functions/{functionId}/executions".replace("{functionId}",e),s={};void 0!==t&&(s.data=t),void 0!==i&&(s.async=i);const r=new URL(this.config.endpoint+n);return yield this.call("post",r,{"content-type":"application/json"},s)})),getExecution:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "functionId"');if(void 0===t)throw new o('Missing required parameter: "executionId"');let i="/functions/{functionId}/executions/{executionId}".replace("{functionId}",e).replace("{executionId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("get",n,{"content-type":"application/json"},{})}))},this.locale={get:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale");return yield this.call("get",e,{"content-type":"application/json"},{})})),getContinents:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/continents");return yield this.call("get",e,{"content-type":"application/json"},{})})),getCountries:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/countries");return yield this.call("get",e,{"content-type":"application/json"},{})})),getCountriesEU:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/countries/eu");return yield this.call("get",e,{"content-type":"application/json"},{})})),getCountriesPhones:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/countries/phones");return yield this.call("get",e,{"content-type":"application/json"},{})})),getCurrencies:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/currencies");return yield this.call("get",e,{"content-type":"application/json"},{})})),getLanguages:()=>n(this,void 0,void 0,(function*(){const e=new URL(this.config.endpoint+"/locale/languages");return yield this.call("get",e,{"content-type":"application/json"},{})}))},this.storage={listFiles:(e,t,i,s,r,a,d)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "bucketId"');let n="/storage/buckets/{bucketId}/files".replace("{bucketId}",e),c={};void 0!==t&&(c.search=t),void 0!==i&&(c.limit=i),void 0!==s&&(c.offset=s),void 0!==r&&(c.cursor=r),void 0!==a&&(c.cursorDirection=a),void 0!==d&&(c.orderType=d);const l=new URL(this.config.endpoint+n);return yield this.call("get",l,{"content-type":"application/json"},c)})),createFile:(e,t,i,r,a,d=(e=>{}))=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');if(void 0===i)throw new o('Missing required parameter: "file"');let n="/storage/buckets/{bucketId}/files".replace("{bucketId}",e),c={};void 0!==t&&(c.fileId=t),void 0!==i&&(c.file=i),void 0!==r&&(c.read=r),void 0!==a&&(c.write=a);const l=new URL(this.config.endpoint+n),p=i.size;if(p<=s.CHUNK_SIZE)return yield this.call("post",l,{"content-type":"multipart/form-data"},c);let u,h;const f={"content-type":"multipart/form-data"};let v=0;const w=Math.ceil(p/s.CHUNK_SIZE);if("unique()"!=t)try{h=yield this.call("GET",new URL(this.config.endpoint+n+"/"+t),f),v=h.chunksUploaded}catch(e){}for(;v<w;v++){const e=v*s.CHUNK_SIZE,t=Math.min(v*s.CHUNK_SIZE+s.CHUNK_SIZE-1,p);f["content-range"]="bytes "+e+"-"+t+"/"+p,u&&(f["x-appwrite-id"]=u);const n=i.slice(e,t+1);c.file=new File([n],i.name),h=yield this.call("post",l,f,c),u||(u=h.$id),d&&d({$id:h.$id,progress:Math.min((v+1)*s.CHUNK_SIZE,p)/p*100,sizeUploaded:t+1,chunksTotal:h.chunksTotal,chunksUploaded:h.chunksUploaded})}return h})),getFile:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let i="/storage/buckets/{bucketId}/files/{fileId}".replace("{bucketId}",e).replace("{fileId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("get",n,{"content-type":"application/json"},{})})),updateFile:(e,t,i,s)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let n="/storage/buckets/{bucketId}/files/{fileId}".replace("{bucketId}",e).replace("{fileId}",t),r={};void 0!==i&&(r.read=i),void 0!==s&&(r.write=s);const a=new URL(this.config.endpoint+n);return yield this.call("put",a,{"content-type":"application/json"},r)})),deleteFile:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let i="/storage/buckets/{bucketId}/files/{fileId}".replace("{bucketId}",e).replace("{fileId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("delete",n,{"content-type":"application/json"},{})})),getFileDownload:(e,t)=>{if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let i="/storage/buckets/{bucketId}/files/{fileId}/download".replace("{bucketId}",e).replace("{fileId}",t),n={};const s=new URL(this.config.endpoint+i);n.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(n)))s.searchParams.append(e,t);return s},getFilePreview:(e,t,i,n,s,r,a,d,c,l,p,u,h)=>{if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let f="/storage/buckets/{bucketId}/files/{fileId}/preview".replace("{bucketId}",e).replace("{fileId}",t),v={};void 0!==i&&(v.width=i),void 0!==n&&(v.height=n),void 0!==s&&(v.gravity=s),void 0!==r&&(v.quality=r),void 0!==a&&(v.borderWidth=a),void 0!==d&&(v.borderColor=d),void 0!==c&&(v.borderRadius=c),void 0!==l&&(v.opacity=l),void 0!==p&&(v.rotation=p),void 0!==u&&(v.background=u),void 0!==h&&(v.output=h);const w=new URL(this.config.endpoint+f);v.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(v)))w.searchParams.append(e,t);return w},getFileView:(e,t)=>{if(void 0===e)throw new o('Missing required parameter: "bucketId"');if(void 0===t)throw new o('Missing required parameter: "fileId"');let i="/storage/buckets/{bucketId}/files/{fileId}/view".replace("{bucketId}",e).replace("{fileId}",t),n={};const s=new URL(this.config.endpoint+i);n.project=this.config.project;for(const[e,t]of Object.entries(this.flatten(n)))s.searchParams.append(e,t);return s}},this.teams={list:(e,t,i,o,s,r)=>n(this,void 0,void 0,(function*(){let n={};void 0!==e&&(n.search=e),void 0!==t&&(n.limit=t),void 0!==i&&(n.offset=i),void 0!==o&&(n.cursor=o),void 0!==s&&(n.cursorDirection=s),void 0!==r&&(n.orderType=r);const a=new URL(this.config.endpoint+"/teams");return yield this.call("get",a,{"content-type":"application/json"},n)})),create:(e,t,i)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "name"');let n={};void 0!==e&&(n.teamId=e),void 0!==t&&(n.name=t),void 0!==i&&(n.roles=i);const s=new URL(this.config.endpoint+"/teams");return yield this.call("post",s,{"content-type":"application/json"},n)})),get:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');let t="/teams/{teamId}".replace("{teamId}",e);const i=new URL(this.config.endpoint+t);return yield this.call("get",i,{"content-type":"application/json"},{})})),update:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "name"');let i="/teams/{teamId}".replace("{teamId}",e),n={};void 0!==t&&(n.name=t);const s=new URL(this.config.endpoint+i);return yield this.call("put",s,{"content-type":"application/json"},n)})),delete:e=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');let t="/teams/{teamId}".replace("{teamId}",e);const i=new URL(this.config.endpoint+t);return yield this.call("delete",i,{"content-type":"application/json"},{})})),getMemberships:(e,t,i,s,r,a,d)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');let n="/teams/{teamId}/memberships".replace("{teamId}",e),c={};void 0!==t&&(c.search=t),void 0!==i&&(c.limit=i),void 0!==s&&(c.offset=s),void 0!==r&&(c.cursor=r),void 0!==a&&(c.cursorDirection=a),void 0!==d&&(c.orderType=d);const l=new URL(this.config.endpoint+n);return yield this.call("get",l,{"content-type":"application/json"},c)})),createMembership:(e,t,i,s,r)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "email"');if(void 0===i)throw new o('Missing required parameter: "roles"');if(void 0===s)throw new o('Missing required parameter: "url"');let n="/teams/{teamId}/memberships".replace("{teamId}",e),a={};void 0!==t&&(a.email=t),void 0!==i&&(a.roles=i),void 0!==s&&(a.url=s),void 0!==r&&(a.name=r);const d=new URL(this.config.endpoint+n);return yield this.call("post",d,{"content-type":"application/json"},a)})),getMembership:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "membershipId"');let i="/teams/{teamId}/memberships/{membershipId}".replace("{teamId}",e).replace("{membershipId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("get",n,{"content-type":"application/json"},{})})),updateMembershipRoles:(e,t,i)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "membershipId"');if(void 0===i)throw new o('Missing required parameter: "roles"');let n="/teams/{teamId}/memberships/{membershipId}".replace("{teamId}",e).replace("{membershipId}",t),s={};void 0!==i&&(s.roles=i);const r=new URL(this.config.endpoint+n);return yield this.call("patch",r,{"content-type":"application/json"},s)})),deleteMembership:(e,t)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "membershipId"');let i="/teams/{teamId}/memberships/{membershipId}".replace("{teamId}",e).replace("{membershipId}",t);const n=new URL(this.config.endpoint+i);return yield this.call("delete",n,{"content-type":"application/json"},{})})),updateMembershipStatus:(e,t,i,s)=>n(this,void 0,void 0,(function*(){if(void 0===e)throw new o('Missing required parameter: "teamId"');if(void 0===t)throw new o('Missing required parameter: "membershipId"');if(void 0===i)throw new o('Missing required parameter: "userId"');if(void 0===s)throw new o('Missing required parameter: "secret"');let n="/teams/{teamId}/memberships/{membershipId}/status".replace("{teamId}",e).replace("{membershipId}",t),r={};void 0!==i&&(r.userId=i),void 0!==s&&(r.secret=s);const a=new URL(this.config.endpoint+n);return yield this.call("patch",a,{"content-type":"application/json"},r)}))}}setEndpoint(e){return this.config.endpoint=e,this.config.endpointRealtime=this.config.endpointRealtime||this.config.endpoint.replace("https://","wss://").replace("http://","ws://"),this}setEndpointRealtime(e){return this.config.endpointRealtime=e,this}setProject(e){return this.headers["X-Appwrite-Project"]=e,this.config.project=e,this}setJWT(e){return this.headers["X-Appwrite-JWT"]=e,this.config.jwt=e,this}setLocale(e){return this.headers["X-Appwrite-Locale"]=e,this.config.locale=e,this}subscribe(e,t){let i="string"==typeof e?[e]:e;i.forEach((e=>this.realtime.channels.add(e)));const n=this.realtime.subscriptionsCounter++;return this.realtime.subscriptions.set(n,{channels:i,callback:t}),this.realtime.connect(),()=>{this.realtime.subscriptions.delete(n),this.realtime.cleanUp(i),this.realtime.connect()}}call(e,t,s={},r={}){var a,d;return n(this,void 0,void 0,(function*(){e=e.toUpperCase(),s=Object.assign({},this.headers,s);let n={method:e,headers:s,credentials:"include"};if("undefined"!=typeof window&&window.localStorage&&(s["X-Fallback-Cookies"]=null!==(a=window.localStorage.getItem("cookieFallback"))&&void 0!==a?a:""),"GET"===e)for(const[e,i]of Object.entries(this.flatten(r)))t.searchParams.append(e,i);else switch(s["content-type"]){case"application/json":n.body=JSON.stringify(r);break;case"multipart/form-data":let e=new FormData;for(const t in r)Array.isArray(r[t])?r[t].forEach((i=>{e.append(t+"[]",i)})):e.append(t,r[t]);n.body=e,delete s["content-type"]}try{let e=null;const s=yield i.fetch(t.toString(),n);if(e=(null===(d=s.headers.get("content-type"))||void 0===d?void 0:d.includes("application/json"))?yield s.json():{message:yield s.text()},400<=s.status)throw new o(null==e?void 0:e.message,s.status,null==e?void 0:e.type,e);const r=s.headers.get("X-Fallback-Cookies");return"undefined"!=typeof window&&window.localStorage&&r&&(window.console.warn("Appwrite is using localStorage for session management. Increase your security by adding a custom domain as your API endpoint."),window.localStorage.setItem("cookieFallback",r)),e}catch(e){if(e instanceof o)throw e;throw new o(e.message)}}))}flatten(e,t=""){let i={};for(const n in e){let o=e[n],s=t?`${t}[${n}]`:n;Array.isArray(o)?i=Object.assign(i,this.flatten(o,s)):i[s]=o}return i}}s.CHUNK_SIZE=5242880;class r{}r.equal=(e,t)=>r.addQuery(e,"equal",t),r.notEqual=(e,t)=>r.addQuery(e,"notEqual",t),r.lesser=(e,t)=>r.addQuery(e,"lesser",t),r.lesserEqual=(e,t)=>r.addQuery(e,"lesserEqual",t),r.greater=(e,t)=>r.addQuery(e,"greater",t),r.greaterEqual=(e,t)=>r.addQuery(e,"greaterEqual",t),r.search=(e,t)=>r.addQuery(e,"search",t),r.addQuery=(e,t,i)=>i instanceof Array?`${e}.${t}(${i.map((e=>r.parseValues(e))).join(",")})`:`${e}.${t}(${r.parseValues(i)})`,r.parseValues=e=>"string"==typeof e||e instanceof String?`"${e}"`:`${e}`,e.Appwrite=s,e.Query=r,Object.defineProperty(e,"__esModule",{value:!0})}(this.window=this.window||{},0,window);
//# sourceMappingURL=/sm/1a9cf4bfb0c0c774dcd42c198d9156feb158abe037d19ff1d4c34d0d94d95e21.map