//cutPart为要切除的键
function cutUrl(url, cutPart) {
    let regExp = new RegExp(cutPart + "=");
    try {
        let front = url.split("?")[0];
        let qCut = url.split("?")[1];
        let andCut = qCut.split("&");
        //只有一个键值对
        if (andCut.length === 1) {
            if (regExp.test(url)) {
                return front;
            } else {
                return url;
            }
        } else {
            //需要在中间插入问号
            let urlBack = '';
            for (let key in andCut) {
                if (!regExp.test(andCut[key])) {
                    urlBack += andCut[key];
                    if (key != andCut.length - 1) {
                        urlBack += "&";
                    }
                } else {
                    if (key == andCut.length - 1) {
                        urlBack = urlBack.substr(0, urlBack.length - 1);
                    }
                }
            }
            return front + "?" + urlBack;
        }
    } catch (e) {
        return url;
    }
}
function getUrlElement(url, getPart) {
    let regExp = new RegExp(getPart + "=");
    try {
        let qCut = url.split("?")[1];
        let andCut = qCut.split("&");
        for(let val of andCut){
            if(regExp.test(val)){
                return val.substr(getPart.length+1,val.length-1-getPart.length);
            }
        }
    } catch (e) {
        return null;
    }
}
function addPage(url) {
    try{
        let qCut1 = url.split("?")[0];
        let qCut2 = url.split("?")[1];
        if(qCut2==null){
            return qCut1 + '?page=1';
        }else{
            return url + '&page=1';
        }
    }catch (e) {
        return url;
    }
}
function addSpecificPage(url,num) {
    try{
        let qCut1 = url.split("?")[0];
        let qCut2 = url.split("?")[1];
        if(qCut2==null){
            return qCut1 + '?page='+num;
        }else{
            return url + '&page='+num;
        }
    }catch (e) {
        return url;
    }
}
function resetPage(url,num) {
    try{
        if(addSpecificPage(cutUrl(url,'page'),num)==null){
            return url;
        }else {
            return addSpecificPage(cutUrl(url,'page'),num);
        }
    }catch (e) {
        return url;
    }
}
function addUrl(url,k,v) {
    try{
        let qCut1 = url.split("?")[0];
        let qCut2 = url.split("?")[1];
        if(qCut2 ==null){
            return qCut1 + '?' + k + '=' + v;
        }else {
            return url + '&' +k +'=' +v;
        }
    }catch (e) {
        return url+'?'+k+'='+v;
    }
}






