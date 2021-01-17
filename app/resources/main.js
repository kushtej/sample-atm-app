new Vue({ 
    el: '#app',
    
    data:{
        savings:false,
        withdrawal:false,
        change_pin:false,
        acc_number:"",
        pin:"",
        item:"",
        login:true,
        buttonshow:false,
        error:false,
        error_msg:'',
        balence:0,
        old_pin:'',
        new_pin:'',
        re_pin:'',
        base_url:"",
        account_savings:'',
    }, 
    created(){
        console.log("Hi");

        var self = this;
        jQuery.ajax({
            url: window.location.origin+'/base/buildurl',
            type: 'GET',
            success: function (result) {
                self.base_url=result;
            },
            failure: function (errMsg) {
                console.log(errMsg)
            }
        })

    },
    methods:{

        downloadStatement(){
            console.log("In download statement");
            var self = this;
            jQuery.ajax({
                url: window.location.origin+'/transaction/download?name=statement',
                type: 'GET',
                success: function (result) {
                    window.location=window.location.origin+'/transaction/download?name=statement'
                },
                failure: function (errMsg) {
                    console.log("error")
                }
            })
        },

        saving(){
            console.log("In savings statement");
            var self = this;
            jQuery.ajax({
                url: window.location.origin+'/transaction/getbalence',
                type: 'GET',
                success: function (result) {
                    self.account_savings=result;
                    console.log(result)
                },
                failure: function (errMsg) {
                    console.log("error")
                }
            })
        },
    
        logout(){
            console.log("In logout")
            var self = this;
            jQuery.ajax({
                url: window.location.origin+'/accounts/logout',
                type: 'GET',
                success: function (result) {
                    if(result == 'true'){
                        self.buttonshow = false;
                        self.login=true;                      
                    }
                },
                failure: function (errMsg) {
                    console.log("error")
                }
            })
        },

        auhthenticate: function (item){           
               this.serverpost();
               item. preventDefault();
        },
        changePin: function (item){
            if(this.new_pin!==this.re_pin){       
                return;
            }
            if(this.new_pin.length < 4 || this.new_pin.length > 4 ) {
                return;
            }
            item. preventDefault();

            var self = this;
            jQuery.ajax({
                data: {'old-password' :this.old_pin, 'new-password':this.new_pin, 'new-repassword':this.re_pin },
                url: window.location.origin+'/accounts/submit/changepin',
                type: 'POST',
                success: function (result) {
                    console.log(result)
                   

                    if(result == "true"){
                        self.error=true;
                self.error_msg="Pin successfully changed";  
                    }else{
                        self.error=true;
                        self.error_msg="Pin not changed try again later";
                    }
                },
                failure: function (errMsg) {
                    console.log(errMsg)   
                }
            })

        },

        serverpost(){
            var self = this;
            jQuery.ajax({
                data: {'acc-number' :this.acc_number, 'pin':this.pin },
                url: window.location.origin+'/accounts/submit/login',
                type: 'POST',
                success: function (result) {
                    if(result == "true"){
                        
                        self.buttonshow = true;
                        self.login=false;                     
                    }else{
                        console.log(result)
                        self.error_msg=result;
                        self.error = true;
                    }
                },
                failure: function (errMsg) {
                    console.log(errMsg)   
                }
            })
            
        },

        cashWithdraw(withdrawAmount){
            jQuery.ajax({
                data: {'amount' :withdrawAmount },
                url: window.location.origin+'/transaction/submit/dashboard',
                type: 'POST',
                success: function (result) {
                    console.log(result)
                    window.location=window.location.origin+"/transaction/download?name=receipt";
                },
                failure: function (errMsg) {
                    console.log("error")
                }
            })
        }
    }, 
    template:
    `
        <div class = "maincontainer">
        <div class = "login" v-show ="login">
        <form method="POST" action="base_url/submit/login">
            <label for="AccountNumber"><b>Account Number</b></label>
            <input type="text" name="acc-number" v-model="acc_number" placeholder="Enter Account Number"  oninput="this.value = this.value.replace(/[^0-9.]/g, '')" name="email" required>
            <label for="pin"><b>Pin</b></label>
            <input type="text" v-model="pin" name="pin" placeholder="Enter password" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  required>
            <input class="submit"  type="submit" value="submit" @click="auhthenticate"/>
            <span v-show ="error">{{error_msg}}</span>
        </form>
        </div>
        
        <div v-if="buttonshow" v-show ="buttonshow">
            <button @click="saving(), savings = !savings, withdrawal = false, change_pin = false">Savings</button>
            <button @click="savings = false, withdrawal = !withdrawal ,change_pin = false ">withdrawal</button>
            <button @click="change_pin = !change_pin, savings = false, withdrawal = false">Change Pin</button>
            <button @click="downloadStatement()">Download Statement</button>
            <button @click="logout()">Logout</button>
        
        </div>
        
        
        <div v-show="savings">
            <h1>{{account_savings}}  </h1>
        </div>
        
        <div v-show="change_pin">
            

            <form method="POST" action="base_url/accounts/submit/changepin">
            <table>
            <tr>
            <td>
            Old Pin 
            </td>
            <td>
            <input type="password" v-model="old_pin" name="old_pin" placeholder="Enter Old pin" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  required>
            </td>
            </tr>
            <tr>
            <td>
            New Pin 
            </td>
            <td>
            <input type="password" v-model="new_pin" name="new_pin" placeholder="Enter New pin" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  required>
            </td>
            </tr>

            <tr>
            <td>
            Re-enter Pin 
            </td>
            <td>
            <input type="password" v-model="re_pin" name="re_pin" placeholder="Re-Enter  pin" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
            </td>
            </tr>
        </table>
        <input class="submit"  type="submit" value="submit" @click="changePin"/>
            <span v-show ="error">{{error_msg}}</span>
        </form>

        </div>
        
        
        <div v-show="withdrawal"  class = "withdrawal" >
            <button @click="cashWithdraw(2000)">$2000</button>
            <button @click="cashWithdraw(1000)">$1000</button>
            <button @click="cashWithdraw(500)">$500</button>
            <button @click="cashWithdraw(100)">$100</button>
            <button @click="cashWithdraw(50)">$50</button>
            <button @click="cashWithdraw(20)">$20</button>
            <button @click="cashWithdraw(10)">$10</button>
            <button @click="cashWithdraw(5)">$5</button>
        </div>
    </div>
    </div>
    `, 



   
});

