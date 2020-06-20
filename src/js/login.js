var formVue = new Vue({
    el: '#loginForm',
    data: {
        loginUser: '',
        loginPass: '',
        loginMistake1:'invisible',
        loginMistake2:'invisible',
    },
    methods: {
        loginSubmit: function () {
            //初始化提示信息的状态
            this.loginMistake1 = "invisible";
            this.loginMistake2 = "invisible";

            let loginInfo = JSON.stringify({username: this.loginUser, userpass: this.loginPass});
            this.$http.post("../php/module/login.php", loginInfo, {emulateJSON: true}).then(result => {
                let temp = result.body.split("\"[")[1];
                let temp2 = temp.substr(0,temp.length-4).replace("\"","");
                let resultArr = temp2.split(",");

                if(resultArr[0] === "false"||this.loginUser===''){
                    this.loginMistake1 = "visible";
                }
                if(resultArr[1] === "false" && resultArr[0] === "true"){
                    this.loginMistake2 = "visible";
                }
                if(resultArr[0] ==="true" && resultArr[1] ==="true"&&this.loginUser!==''){
                    let logInfo = JSON.stringify({username:this.loginUser,userid:resultArr[2]});
                    this.$http.post("../php/module/token.php",logInfo,{emulateJSON:true}).then(result=>{
                        window.location = "../../index.html?id="+result.body.trim().split('\"')[1];
                    });
                }
            });
        }
    },
});