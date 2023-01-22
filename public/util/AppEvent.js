const AppEvent = function () {
    const registers = {
        on: {},
        once: {}
    }

    const getGuid = function (listener, mode) {
        let guid = Guid();
        let guids = [];

        do {
            guids = Object.keys(registers[mode][listener]);
            guid = Guid();
        }

        while (guids.indexOf(guid) >= 0);

        return guid;
    }

    this.on = (listener, listenerFunc, registerFunc) => {
        if (registers.on[listener] === undefined) registers.on[listener] = {};
        const guid = getGuid(listener, 'on');
        registers.on[listener][guid] = listenerFunc;
        if (typeof registerFunc === 'function') registerFunc({ guid });
    }

    this.once = (listener, listenerFunc, registerFunc) => {
        if (registers.once[listener] === undefined) registers.once[listener] = {};
        const guid = getGuid(listener, 'once');
        registers.once[listener][guid] = listenerFunc;
        if (typeof registerFunc === 'function') registerFunc({ guid });
    }

    this.off = async (listener, guid) => {
        if (registers.on[listener] !== undefined) {
            if (guid) {
                if (registers.on[listener][guid] !== undefined) delete registers.on[listener][guid];
            }

            else {
                if (registers.on[listener] !== undefined) delete registers.on[listener];
            }
        }

        if (registers.once[listener] !== undefined) {
            if (guid) {
                if (registers.once[listener][guid] !== undefined) delete registers.once[listener][guid];
            }

            else {
                if (registers.once[listener] !== undefined) delete registers.once[listener];
            }
        }
    }

    this.emit = async (listener, ...args) => {
        const callers = [];

        if (registers.on[listener] !== undefined) {
            for (const key of Object.keys(registers.on[listener]))
                for (const caller of registers.on[listener][key]) callers.push({ guid: key, caller });
        }

        if (registers.once[listener] !== undefined) {
            for (const key of Object.keys(registers.once[listener]))
                for (const caller of registers.once[listener][key]) {
                    callers.push({ guid: key, caller });
                    delete registers.once[listener][key];
                }
        }

        for (const { guid, caller } of callers) {
            try {

                await caller.apply(null, [guid].concat(args));
            }

            catch (error) {
                console.error(error);
            }
        }
    }

    return this;
}

const $event = new AppEvent();