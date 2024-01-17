const nl2br = (str) => {
    let response = str.replace(/\r\n/g, "<br>");
    response = response.replace(/(\n|\r)/g, "<br>");
    return response;
}

export { nl2br }