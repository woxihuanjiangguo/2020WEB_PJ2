var detailBody = new Vue({
    el: '#detailBody',
    data: {
        title: '',
        author: '',
        path: '../../img/image/badpic.jpg',
        description: 'No detailed description for now! Sorry!',
        likedNumber: '',
        content: '',
        country: '',
        city: '',
        ifShow:false,
        likeOrNot:'',
    },
    methods: {
        getInfo: function () {
            let picUser = JSON.stringify({uid:getUrlElement(location.href,'id'),
                pid:getUrlElement(location.href,'picId')});
            this.$http.post('../php/module/detail.php',
                picUser,
                {emulateJSON: true}
            ).then(result => {
                let detailInfo = Object.values(result.body);
                console.log(detailInfo);
                this.title = detailInfo[0].title;
                this.author = detailInfo[1].user;
                if(detailInfo[0].path !== null){
                    this.path = '../../img/travel-images/large/' + detailInfo[0].path;
                }
                if (detailInfo[0].description !== null) {
                    this.description = detailInfo[0].description;
                }
                this.likedNumber = detailInfo[2].liked;
                this.content = detailInfo[0].content;
                this.city = detailInfo[3].city;
                this.country = detailInfo[4].country;
                if(detailInfo[5].likeExists === 'true'){
                    this.likeOrNot = '../../img/icon/liked.png';
                }else{
                    this.likeOrNot = '../../img/icon/like.png';
                }
            });
        },
        likeIt:function () {
            if(getUrlElement(location.href,'id')==null){
                this.ifShow = true;
            }else{
                let x;
                if(this.likeOrNot === '../../img/icon/like.png'){
                    x = 'like';
                    this.likeOrNot = '../../img/icon/liked.png';
                }else{
                    x = 'liked';
                    this.likeOrNot ='../../img/icon/like.png';
                }
                let picUser = JSON.stringify({uid:getUrlElement(location.href,'id'),
                    pid:getUrlElement(location.href,'picId'),status:x});
                this.$http.post('../php/module/like.php',picUser,
                    {emulateJSON: true}).then(result=>{
                    console.log(result.body);
                })
            }

        }
    },
    created: function () {
        this.getInfo();
    }

});