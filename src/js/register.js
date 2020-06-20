
var registerForm = new Vue({
    el:'#registerForm',
    data:{
        noMistake1:'invisible',
        noMistake2:'invisible',
        noMistake3:'invisible',
        noMistake4:'invisible',
        message1:'Invalid user name!',
        message2:'Invalid e-mail address!',
        regUser:'',
        regPass:'',
        regPassConfirm:'',
        regEmail:'',
    },
    methods:{
        /*用户输入规范
        * 用户名：不得含有!@#$%^&*()，不得有汉字,只能有数字、字母、下划线,3-20位
        * 密码：应同时包含字母与数字，不得有特殊符号,6-18位
        * 邮箱：即传统邮箱规范
        * */
        infoCheck:function () {
            let judge = [false,false,false,false];

            if(/^([a-zA-Z0-9_-]){3,20}$/.test(this.regUser)){
                judge[0] = true;
            }
            if(/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,18}$/.test(this.regPass)){
                judge[1] = true;
            }
            if(this.regPassConfirm === this.regPass){
                judge[2] = true;
            }
            if(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(this.regEmail)){
                judge[3] = true;
            }
            for(let i = 0;i<4;i++){
                if(!judge[i]){
                    switch (i) {
                        case 0:this.noMistake1 = "visible";break;
                        case 1:this.noMistake2 = "visible";break;
                        case 2:this.noMistake3 = "visible";break;
                        case 3:this.noMistake4 = "visible";break;
                    }
                }else{
                    switch (i) {
                        case 0:this.noMistake1 = "invisible";break;
                        case 1:this.noMistake2 = "invisible";break;
                        case 2:this.noMistake3 = "invisible";break;
                        case 3:this.noMistake4 = "invisible";break;
                    }
                }
            }
            if(judge[0]&&judge[1]&&judge[2]&&judge[3]){
                let newUser = JSON.stringify({username:this.regUser,password:this.regPass,email:this.regEmail});
                this.$http.post("../php/module/register.php",newUser,{emulateJSON:true}).then(result=>{
                    //判断是否有重复的用户名与邮箱
                    let temp = result.body.split("\"[")[1];
                    let temp2 = temp.substr(0,temp.length-4).replace("\"","");
                    let resultArr = temp2.split(",");

                    if(resultArr[0] === "true"){
                        this.message1 = "This user name has been used!";
                        this.noMistake1 = "visible";
                    }
                    if(resultArr[1] === "true"){
                        this.message2 = "This e-mail has been used!";
                        this.noMistake4 = "visible";
                    }
                    //登录信息
                    if(resultArr[0]==="false"&&resultArr[1]==="false"){
                        let logInfo = JSON.stringify({username:this.regUser,userid:resultArr[2]});
                        this.$http.post("../php/module/token.php",logInfo,{emulateJSON:true}).then(result=>{
                            window.location = "../../index.html?id="+result.body.trim().split('\"')[1];
                        });
                    }
                });
            }

            this.message1 = 'Invalid user name!';
            this.message2 = 'Invalid e-mail address!';


        },

    }
});

