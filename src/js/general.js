let completeUrl = window.location.href;
let userId;
let urlArray;
let urlBack;
let hasUrl = true;


try {
    if(!/\?/.test(window.location.href)){
        hasUrl = false;
    }else {
        urlBack = window.location.href.split("?")[1];
        urlArray = urlBack.split("&");
        for (value of urlArray) {
            if (/^(id=)/.test(value)) {
                userId = value.split("=")[1];
            }
        }
    }
} catch (e) {
    userId = "";
}
window.onload = function () {
    if (userId !== "" && userId !== undefined) {
        navVue.isLogged = true;
    }
};

var navVue = new Vue(
    {
        el: '#navTop',
        data: {
            isLogged: false,
            browseHref: addPage('src/html/browse.html' +(hasUrl?'?'+urlBack:'')),
            searchHref: addPage('src/html/search.html' +(hasUrl?'?'+urlBack:'')),
            mineHref:addPage('src/html/mine.html'+(hasUrl?'?'+urlBack:'')),
            favorHref:addPage('src/html/favor.html'+(hasUrl?'?'+urlBack:'')),
            uploadHref:'src/html/upload.html'+(hasUrl?'?'+urlBack:''),

            elseGoHome: cutUrl('../../index.html' +(hasUrl?'?'+urlBack:''),'page'),
            elseGoSearch: addPage(cutUrl('search.html' +(hasUrl?'?'+urlBack:''),'page')),
            elseGoBrowse: addPage(cutUrl('browse.html' +(hasUrl?'?'+urlBack:''),'page')),
            elseGoMine:addPage(cutUrl('mine.html' +(hasUrl?'?'+urlBack:''),'page')),
            elseGoFavor:addPage(cutUrl('favor.html' +(hasUrl?'?'+urlBack:''),'page')),
            elseGoUpload:cutUrl('upload.html' +(hasUrl?'?'+urlBack:''),'page'),

            detailGoHome:cutUrl('../../index.html'+'?'+urlBack,'picId'),
            detailGoBrowse:addPage(cutUrl('browse.html'+'?'+urlBack,'picId')),
            detailGoSearch:addPage(cutUrl('search.html'+'?'+urlBack,'picId')),
            detailGoUpload:cutUrl('upload.html'+'?'+urlBack,'picId'),
            detailGoMine:addPage(cutUrl('mine.html'+'?'+urlBack,'picId')),
            detailGoFavor:addPage(cutUrl('favor.html'+'?'+urlBack,'picId')),
        },
        methods: {
            logOut: function (e) {
                //true控制用户界面的跳转
                if(e){
                    userId = "";
                    window.location = 'login.html';
                }else{
                    userId = "";
                    window.location = 'src/html/login.html';
                }

            }
        }

    }
);
