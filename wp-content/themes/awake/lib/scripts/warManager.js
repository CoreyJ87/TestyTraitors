/**
 * Created by cjones on 11/19/2014.
 */

/*var conn = new WebSocket('ws://eznetservers.com:8085');
conn.onopen = function (e) {
    console.log("Connection established!");
    console.log(e.data)
};
conn.onmessage = function (e) {
    console.log(jQuery.parseJSON(e.data));
};*/

jQuery(document).ready(function () {

});

function startChecking(){
    if(typeof(php_obj) == "undefined"){
        setTimeout(function(){
            startChecking();
        },500)
    }
    else{
        return initObj(php_obj,$('#wmanager_limit').val());
    }

}

function initObj(new_obj,limit) {;
    for (var x = 0; x <= limit; x++) {
        new_obj[x].updateThis = function(newStarValue,newHitValue,newClaimedValue){
            this.stars=newStarValue;
            this.hit=newHitValue;
            this.claimed=newClaimedValue;
            sendObj(conn,new_obj);
        }
        new_obj[x].resetValues = function(){
            this.stars=0;
            this.hit=false;
            this.claimed=false;
            sendObj(conn,new_obj);
        }
    }
    return new_obj;
}

function sendObj(conn, obj) {
    var stringified = JSON.stringify(obj);
    conn.send(stringified);
}

php_obj = startChecking();