const AppRequest = function () {
    const instance = {}

    const send = ({ url = "", method = "GET", data = {}, headers = {} }) => {
        const request = XmlRequest.create({ url, method, data, headers });
        return request.send();
    };

    const getHeaders = function (value = {}) {
        const headers = {};
        const jsonString = JSON.stringify(value);

        headers['Content-Type'] = 'application/json';
        headers['Content-Length'] = jsonString.length;
        headers['Accept'] = 'application/json';
        headers['user-agent'] = navigator.userAgent;
        headers['connection'] = "keep-alive";
        headers['origin'] = window.location.origin;

        return headers;
    }

    const getQueryString = function (data) {
        let queryString = "";

        if (!(Object.keys(data).length > 0)) return queryString;
        else queryString = "?";

        for (const key in data)
            queryString = `${key}=${data[key]}`;

        return queryString;
    }

    const getUri = function (url, data) {
        return `${url}${getQueryString(data)}`;
    }

    instance.get = (url, data = {}) => {
        return send({ url: getUri(url, data), data, method: "GET", headers: getHeaders(data) });
    }

    instance.post = (url, data = {}) => {
        return send({ url: url, data, method: "POST", headers: getHeaders(data) });
    }

    instance.put = (url, data = {}) => {
        return send({ url: url, data, method: "PUT", headers: getHeaders(data) });
    }

    instance.delete = () => {

    }

    return instance;
}

const $request = new AppRequest()