/*
    This function prevents the user being able to search for venues in the past,
    and also stops them from going any further than a year in advance.
*/

function setDateBoundaries(dateID){
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1; //0-indexed: add 1 to get actual month
    let yyyy = today.getFullYear();
    if (dd < 10) {
    dd = '0' + dd
    }
    if (mm < 10) {
    mm = '0' + mm
    }

    // Set minimum value for date input (today)
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById(dateID).setAttribute("min", today);

    // Set maximum value for date input (today + 3 year)
    yyyy+=3;
    future_date = yyyy + "-" + mm + "-" + dd;
    document.getElementById(dateID).setAttribute("max", future_date);
}