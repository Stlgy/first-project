function verificApaga(ev){
    let qual = ev.target;
    let msg = qual.text;/*qual verifica link que carreguei*/
    console.log(msg);/*msg texto no link*/
    if(confirm("Are you sure you want to delete " + msg)){
        return true;
    }else{
        return false;
    }
}

function currentTime() {

    let date = new Date();
    let hh = date.getHours();
    let mm = date.getMinutes();
    let ss = date.getSeconds();

    hh = (hh < 10) ? '0' + hh : hh;
    mm = (mm < 10) ? '0' + mm : mm;
    ss = (ss < 10) ? '0' + ss : ss;

    let time = hh + ":" + mm + ":" + ss;
    console.log("Hora: " + time);
    document.getElementById("clock").innerText = time;
    let t = setTimeout(function() { currentTime() }, 1000);
};

currentTime();