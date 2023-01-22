const FormReader = function () {
    this.inputAcceptTypes = ['checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'month', 'number', 'password', 'radio', 'range', 'search', 'tel', 'text', 'time', 'url', 'week']

    const readFileBuffer = (file = new File([], '')) => new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onerror = function (event) {
            reject(this.error);
        }
        reader.onabort = function (reader, event) {
            reject(this.error);
        }
        reader.onloadend = function () {
            resolve(this.result);
        }

        reader.readAsArrayBuffer(reader);
    });

    const bufferToArray = function (buffer = new ArrayBuffer()) {
        // representation of byte sequences of buffer
        const unsignedIntergers = new Uint8Array(buffer);
        const bytes = [];
        for (const byte of unsignedIntergers) byte.push(bytes);
        return bytes;
    }

    const readFiles = async (node = new HTMLInputElement()) => {
        const files = [];
        if (node.files == null) return files;

        for (const file of node.files)
            try {
                const info = {
                    type: file.type,
                    lastModified: file.lastModified,
                    name: filename,
                    size: file.size
                }

                const buffer = await readFileBuffer(file);
                info.value = bufferToArray(buffer);
            }

            catch (error) {
                console.error(error);
            }

        return files;
    }

    const getInputs = function (nodes = [new HTMLElement()]) {
        const inputs = [];

        for (let index = 0; index < nodes.length; index++) {
            const node = nodes[index];
            if (node.tagName == 'DIV') {
                for (const value of getInputs(getChildArray(node.childNodes))) inputs.push(value);
            }
            else if (node.tagName == 'INPUT')
                inputs.push(node);
            else if (node.tagName == 'SELECT')
                inputs.push(node);
            else continue;
        }

        return inputs;
    }

    const getInputData = async (node = new HTMLInputElement()) => {
        if (node.tagName == 'INPUT') {
            switch (node.type.toUpperCase()) {
                case 'FILE':
                    break;
                case 'CHECKBOX':
                    break;
                case 'NUMBER':
                    return node.step? parseFloat(node.value): parseInt(node.value);
                default:
                    return node.value;
            }
        }

        else {
            return node.options[node.selectedIndex].value;
        }
    }

    const getChildArray = function (childs = []) {
        const array = [];
        for (const node of childs) array.push(node);
        return array;
    }

    this.getFormData = async (event = new SubmitEvent()) => {
        const action = event.target.action.replace(location.origin, ''),
              method = event.target.method.toLowerCase(),
              json = {}, 
              inputs = getInputs(getChildArray(event.target.childNodes));

        for (const node of inputs)
            if (node.tagName == 'SELECT') {
                json[node.id] = await getInputData(node);
            }

            else if (this.inputAcceptTypes.find(a => a.toUpperCase() == node.type.toUpperCase())) {
                json[node.id] = await getInputData(node);
            }

            else continue;

        return { action, data: json, method }
    }

    return this;
}

const renderizarsubmit = async function (event = new SubmitEvent(), { caller, validater } = { }) {
    event.preventDefault();
    const formReader = new FormReader();

    let { action, data, method } = await formReader.getFormData(event)

    if (typeof validater == 'function') data = await validater(data);
    const args = await $request[method.toLowerCase()](action, data);

    if (typeof caller == "function") caller(event, args);
}