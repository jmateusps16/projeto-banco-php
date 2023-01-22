class XmlRequest {
    _request = new XMLHttpRequest();
    _url = '';
    _method = '';
    _data = {};
    _headers = {};

    constructor ({ url, method, data, headers }) {
        this._url = url;
        this._method = method;
        this._data = data;
        this._headers = headers;
    }

    setHeaders() {
        for (const key in this._headers)
            this._request.setRequestHeader(key, this._headers[key]);
    }

    send() {
        return new Promise((resolve, reject) => {
            const onErroHandler = function (context = new XmlRequest(), event) {
                try {
                    reject({ code: event.target.status, status: event.target.statusText, response: JSON.parse(event.target.responseText), request: context._data, type: event.target.responseType,  })
                }

                catch {
                    reject({ code: event.target.status, status: event.target.statusText, response: event.target.responseText, request: context._data, type: event.target.responseType,  })
                }
            }

            const onAbortHandler = function (context = new XmlRequest(), event) {
                try {
                    reject({ code: event.target.status, status: event.target.statusText, response: JSON.parse(event.target.responseText), request: context._data, type: event.target.responseType,  })
                }

                catch {
                    reject({ code: event.target.status, status: event.target.statusText, response: event.target.responseText, request: context._data, type: event.target.responseType,  })
                }
            }

            const onLoadEndHandler = function (context = new XmlRequest(), event) {
                try {
                    resolve({ code: event.target.status, status: event.target.statusText, response: JSON.parse(event.target.responseText), request: context._data, type: event.target.responseType,  })
                }

                catch {
                    resolve({ code: event.target.status, status: event.target.statusText, response: event.target.responseText, request: context._data, type: event.target.responseType,  })
                }
            }

            this._request.onerror = (event) => onAbortHandler.apply(null, [this, event]);
            this._request.onabort = (event) => onAbortHandler.apply(null, [this, event]);
            this._request.onloadend = (event) => onLoadEndHandler.apply(null, [this, event]);

            this._request.timeout = 12000;
            this._request.open(this._method.toUpperCase(), this._url, true);
            this.setHeaders()
            this._request.send(JSON.stringify(this._data));
        })
    }

    static create({ url, method, data, headers }) {
        return new XmlRequest({ url, method, data, headers });
    }
}