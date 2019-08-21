export default class Eventful {

    eventHandlers = {};

    _assignHandler(eventName, handler) {
        let list = this.eventHandlers[eventName];
        if (list === undefined) {
            throw "Unlisted event";
        }
        if (typeof handler !== "function") {
            throw "A function is expected as event handler";
        }
        list.push(handler);
    }

    _dispatch(eventName, ...args) {
        let list = this.eventHandlers[eventName];
        if (list === undefined) {
            throw "Unlisted event";
        }

        list.forEach(handler => handler.call(this, ...args));
    }

    on(event, handler) {
        if (event instanceof Array) {
            event.map(eventName => this._assignHandler(eventName, handler));
        } else {
            this._assignHandler(event, handler);
        }
    }

    trigger(event, ...args) {
        if (event instanceof Array) {
            event.map(eventName => this._dispatch(eventName, ...args));
        } else {
            this._dispatch(event, ...args);
        }
    }

}