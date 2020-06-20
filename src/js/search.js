window.onbeforeunload = function () {
    window.location = resetPage(window.location, 1);
};
var searchWhole = new Vue({
    el: '#searchWhole',
    data: {
        thisUrl: window.location.href,
        //搜索区域
        searchMethod: '0',
        warnuser: 'Search By',
        sContent: '',

        //图部分
        showPic: [],
        allPic: [],
        pages: 5,
        ifEmpty: false,
        //分页组件
        ifactive1: '',
        ifactive2: '',
        ifactive3: '',
        ifactive4: '',
        ifactive5: '',
        ifshow2: true,
        ifshow3: true,
        ifshow4: true,
        ifshow5: true,
        widthx: '',


    },
    methods: {
        //切换搜索方式 t为标题 d为内容
        alter: function (v) {
            switch (v) {
                case 1:
                    this.searchMethod = 't';
                    this.warnuser = 'Search By title';
                    break;
                case 2:
                    this.searchMethod = 'd';
                    this.warnuser = 'Search By description';
                    break;
            }
        },
        doSearch: function () {
            switch (this.searchMethod) {
                case '0':
                    this.warnuser = "Choose your method please!";
                    break;
                case "t":
                    this.getPic(5,this.sContent);
                    break;
                case "d":
                    this.getPic(6,this.sContent);
                    break;

            }
        },


        //页码控制
        arrow1: function () {
            let x = getUrlElement(this.thisUrl, 'page');
            if (x !== '1') {
                switch (x) {
                    case '2':
                        this.ifactive2 = '';
                        this.ifactive1 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 1);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(1);
                        break;
                    case '3':
                        this.ifactive3 = '';
                        this.ifactive2 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 2);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(2);
                        break;
                    case '4':
                        this.ifactive4 = '';
                        this.ifactive3 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 3);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(3);
                        break;
                    case '5':
                        this.ifactive5 = '';
                        this.ifactive4 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 4);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(4);
                        break;
                }
            }
        },
        arrow2: function () {
            let x = getUrlElement(this.thisUrl, 'page');
            if (x !== this.pages.toString()) {
                switch (x) {
                    case '1':
                        this.ifactive1 = '';
                        this.ifactive2 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 2);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(2);
                        break;
                    case '2':
                        this.ifactive2 = '';
                        this.ifactive3 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 3);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(3);
                        break;
                    case '3':
                        this.ifactive3 = '';
                        this.ifactive4 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 4);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(4);
                        break;
                    case '4':
                        this.ifactive4 = '';
                        this.ifactive5 = 'active';
                        this.thisUrl = resetPage(this.thisUrl, 5);
                        history.replaceState(null, '', this.thisUrl);
                        this.setPic(5);
                        break;
                }
            }
        },
        goToPage: function (t) {
            let x = getUrlElement(this.thisUrl, 'page');
            if (t.toString() !== x) {
                switch (x) {
                    case '1':
                        this.ifactive1 = '';
                        break;
                    case '2':
                        this.ifactive2 = '';
                        break;
                    case '3':
                        this.ifactive3 = '';
                        break;
                    case '4':
                        this.ifactive4 = '';
                        break;
                    case '5':
                        this.ifactive5 = '';
                        break;
                }
                switch (t.toString()) {
                    case '1':
                        this.ifactive1 = 'active';
                        break;
                    case '2':
                        this.ifactive2 = 'active';
                        break;
                    case '3':
                        this.ifactive3 = 'active';
                        break;
                    case '4':
                        this.ifactive4 = 'active';
                        break;
                    case '5':
                        this.ifactive5 = 'active';
                        break;
                }
                this.thisUrl = resetPage(this.thisUrl, t);
                history.replaceState(null, '', this.thisUrl);
                this.setPic(t);

            }
        },
        initPage() {
            //控制最大下标
            this.widthx = (this.pages + 2) * 38.5;
            switch (getUrlElement(this.thisUrl, 'page')) {
                case '1':
                    this.ifactive1 = 'active';
                    break;
                case '2':
                    this.ifactive2 = 'active';
                    break;
                case '3':
                    this.ifactive3 = 'active';
                    break;
                case '4':
                    this.ifactive4 = 'active';
                    break;
                case '5':
                    this.ifactive5 = 'active';
                    break;
            }
            switch (this.pages) {
                case 1:
                    this.ifshow2 = this.ifshow3 = this.ifshow4 = this.ifshow5 = false;
                    break;
                case 2:
                    this.ifshow3 = this.ifshow4 = this.ifshow5 = false;
                    break;
                case 3:
                    this.ifshow4 = this.ifshow5 = false;
                    break;
                case 4:
                    this.ifshow5 = false;
                    break;
            }
        },
        resetPage: function () {
            this.thisUrl = resetPage(this.thisUrl, 1);
            history.replaceState(null, '', this.thisUrl);

            this.pages = 5;
            this.ifEmpty = false;
            this.widthx = '';
            this.ifactive1 = '';
            this.ifactive2 = '';
            this.ifactive3 = '';
            this.ifactive4 = '';
            this.ifactive5 = '';
            this.ifshow2 = true;
            this.ifshow3 = true;
            this.ifshow4 = true;
            this.ifshow5 = true;
        },
        //图片与搜索逻辑的提交
        getPic: function (logic, content) {
            console.log(content);
            if (logic === 4 && content.length === 1) {
            } else {
                let message = {logic: logic, content: content};
                message = JSON.stringify(message);
                //logic 0:无条件限制 1:国家 2:城市 3:内容 4:内容+城市 5:模糊查询 6:模糊查询2
                //content 0:无内容 1:iso 2:cid 3:内容 4：开头字母+cid 5:查询标题部分 6：查询描述
                this.$http.post('../php/module/search.php', message, {emulateJSON: true}).then(result => {
                    //页面数据初始化
                    this.resetPage();


                    this.allPic = Object.values(result.body);
                    this.pages = Math.ceil(this.allPic.length / 6);

                    if (this.pages === 0) {
                        this.pages = 1;
                        this.ifEmpty = true;
                        this.thisUrl = resetPage(this.thisUrl, 1);
                        history.replaceState(null, '', this.thisUrl);

                    }
                    this.setPic(getUrlElement(this.thisUrl, 'page'));
                    this.initPage();
                });
            }
        },
        //currentPage
        setPic: function (cp) {
            if (cp === this.pages) {
                let sliceStart = 6 * (this.pages - 1);
                this.showPic = Object.values(this.allPic.slice(sliceStart, this.allPic.length));
            } else {
                this.showPic = Object.values(this.allPic.slice((cp - 1) * 6, cp * 6));
            }
        },
        picJump: function (pid) {
            window.location = cutUrl(
                addUrl('detail.html' + (hasUrl ? '?' + urlBack : '&'), 'picId', pid), 'page');
        },
    },





    created: function () {
        this.getPic(0, 0);
    }
});