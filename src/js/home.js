var homeWhole = new Vue({
   el:'#homeWhole',
   data:{
       headPic:[],
       bodyPic:[],
   },
   methods:{
       refresh:function () {
            window.location.reload();
       },
       goTop:function(){
           document.body.scrollTop = document.documentElement.scrollTop = 0;
       },
       getHeadPic:function () {
            this.$http.post('src/php/module/homeHead.php','',{emulateJSON:true}).then(result=>{
                this.headPic = Object.values(result.body);
            });
       },
       getBodyPic:function () {
           this.$http.post('src/php/module/homeBody.php','',{emulateJSON:true}).then(result=>{
               this.bodyPic = Object.values(result.body);
           });
       },
       picJump:function (pid) {
            window.location = addUrl('src/html/detail.html'+(hasUrl?'?'+urlBack:''),'picId',pid);
       }
   },
   created:function () {
        this.getHeadPic();
        this.getBodyPic();
   },
});


