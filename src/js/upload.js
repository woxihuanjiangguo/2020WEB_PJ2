var uploadWhole = new Vue({
    el: '#uploadWhole',
    data: {
        thisUrl: window.location.href,
        //多级选择栏
        sContent: '',
        sCountry: 0,
        sCity: 0,
        constant0: 0,
        contents: ['Scenery', 'City', 'People', 'Animal', 'Building', 'Wonder', 'Other'],
        countries: [],
        cities: [],

        sTitle: '',
        sDescription: '',

        ifShowClickButton: true,
        previewPic: '',
        //提交的东西
        file: '',
        param: {
            title: '',
            description: '',
            content: '',
            country: '',
            city: '',
            uid:'',
        },

        warn1: false,
        warn2: false,
        warn3: false,
        warn4: false,
        warn5: false,
        good: false,
        bad: false,

    },
    methods: {
        reloadToMine: function () {
            setTimeout(function () {
                window.location = addPage(cutUrl('mine.html' + (hasUrl ? '?' + urlBack : ''), 'page'));
            }, 2000);
        },
        submitForm: function () {
            this.warn1 = this.warn2 = this.warn3 = this.warn4 = this.bad = false;


            let fill1 = true, fill2 = true, fill3 = true, fill4 = true;
            if (this.sCity === 0) {
                fill1 = false;
                this.warn1 = true;
            }
            if(this.cities.length===0){
                if(this.sCountry!==0){
                    fill1 = true;
                    this.warn1 = false;
                }
            }




            //判断图片是否有图片
            if (this.file == '') {
                fill2 = false;
                this.warn2 = true;
            }
            if (this.sTitle === '') {
                fill3 = false;
                this.warn3 = true;
            }
            if (this.sDescription === '') {
                fill4 = false;
                this.warn4 = true;
            }

            if (fill1 && fill2 && fill3 && fill4) {
                let formData = new FormData();
                this.param['title'] = this.sTitle;
                this.param['description'] = this.sDescription;
                this.param['content'] = this.sContent;
                this.param['country'] = this.sCountry;
                this.param['city'] = this.sCity;
                this.param['uid'] =getUrlElement(this.thisUrl,'id');
                formData.append('file', this.file);
                formData.append('param', JSON.stringify(this.param));

                this.$http.post('../php/module/upload.php', formData
                    , {emulateJSON: true}).then(result => {


                    if (result.body == 'good') {
                        this.good = true;
                        this.reloadToMine();
                    } else {
                        this.bad = true;
                        console.log(result.body);


                    }

                });


            }


        },
        getFile(e) {
            this.file = '';
            this.ifShowClickButton = false;
            this.warn2 = false;
            //显示部分
            let that = this;
            let f = new FileReader();
            f.readAsDataURL(this.$refs.img.files[0]);
            f.onload = function () {
                that.previewPic = f.result;
            }
            //提交逻辑
            this.file = event.target.files[0];
        },
        //select
        getCountry: function () {
            this.$http.post('../php/module/select/selectCountry.php', '', {emulateJSON: true}).then(result => {
                this.countries = Object.values(result.body);
                result = null;
            });
        },
        getCity: function () {
            this.sCity = this.constant0;
            this.$http.post('../php/module/select/selectCity.php', this.sCountry, {emulateJSON: true}).then(result => {
                this.cities = Object.values(result.body);
            });
        },


        initializeSelect: function () {
            this.sContent = this.contents[0];
            this.getCountry();
        },
    },
    created: function () {
        this.initializeSelect();
    }

});