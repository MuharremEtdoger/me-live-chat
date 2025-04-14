require("./bootstrap");Echo.channel("chat."+userId).listen(".message.sent",e=>{let s=`
            <div class="card">
                <div class="card-body">
                    <strong>${e.message.sender.name}:</strong> ${e.message.message}
                </div>
            </div>
        `;document.getElementById("messages").innerHTML+=s});
