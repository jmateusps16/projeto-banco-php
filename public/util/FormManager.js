const clearChildrens = function (id) {
    const element = document.getElementById(id);

    for (const node of element.childNodes)
        element.removeChild(node);
}

const createElementAndSetValues = function (id, children) {
    clearChildrens(id);
    const element = document.getElementById(id);
    children.element = document.createElement(children.tag);

    for (const attribute in children.attributes)
        children.element[attribute] = children.attributes[attribute];
    for (const _event in children.events)
        children.element[_event] = children.events[_event];
    for (const _children of children.childrens)
        children.element.innerHTML += _children;

    element.appendChild(children.element);
}