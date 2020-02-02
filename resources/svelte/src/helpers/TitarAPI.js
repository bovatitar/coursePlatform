import AuthHelper from "./AuthHelper";

class TitarAPI{
    get(url, options = null){
        return new Promise((resolve, reject) => {
            this.request(url,'get',options).then((data) => {
                if(data !== null && data.code >= 200 && data.code < 300){
                    resolve(data);
                }else{
                    reject(data);
                }
            }).catch((err) => {
                reject(err)
            })
        })
    }

    post(url, body, options = null){
        options = {
            ...options,
            body:body
        };
        return new Promise((resolve, reject) => {
            this.request(url,'post',options).then((data) => {
                if(data !== null && data.code >= 200 && data.code < 300){
                    resolve(data);
                }else{
                    reject(data);
                }
            }).catch((err) => {
                reject(err)
            })
        })
    }

    put(url, body, options = null){
        options = {
            ...options,
            body:body
        };
        return new Promise((resolve, reject) => {
            this.request(url,'put',options).then((data) => {
                if(data !== null && data.code >= 200 && data.code < 300){
                    resolve(data);
                }else{
                    reject(data);
                }
            }).catch((err) => {
                reject(err)
            })
        })
    }

    delete(url, options = null){
        options = {
            ...options,
        };
        return new Promise((resolve, reject) => {
            this.request(url,'delete',options).then((data) => {
                if(data !== null && data.code >= 200 && data.code < 300){
                    resolve(data);
                }else{
                    reject(data);
                }
            }).catch((err) => {
                reject(err)
            })
        })
    }

    request(url, method, options = null){
        method = method.toLowerCase();
        let contentType;
        switch (method) {
            case 'get':
                contentType = "application/json";
                break;
            case 'post':
                contentType = "application/json";
                break;
            default:
                contentType = "";
                break;
        }
        return new Promise((resolve, reject) => {
            fetch(url,{
                ...options,
                method:method,
                headers:new Headers({
                    "Authorization":"Bearer "+AuthHelper.getToken(),

                })
            }).then((response) => {
                resolve(response.json());
            }).catch((err) => {
                reject(err);
            })
        })
    }

}

export default new TitarAPI();
