const nl2br = (str) => {
    let response = str.replace(/\r\n/g, "<br>");
    response = response.replace(/(\n|\r)/g, "<br>");
    return response;
}

const getToday = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = ("0"+(today.getMonth()+1)).slice(-2);
    const dd = ("0"+today.getDate()).slice(-2);
    return yyyy+'-'+mm+'-'+dd;
}

export { nl2br, getToday }