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
        base_url:window.location.origin,
        account_savings:'',
    }, 
    created(){

    },
    methods:{

        downloadStatement(){
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/transaction/download?name=statement',
                type: 'GET',
                success: function (result) {
                    window.location=window.location.origin+"/transaction/download?name=statement";
                },
                failure: function (errMsg) {
                }
            })
        },

        saving(){
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/transaction/getbalence',
                type: 'GET',
                success: function (result) {
                    self.account_savings=result;
                },
                failure: function (errMsg) {
                }
            })
        },
    
        logout(){
            var self = this;
            jQuery.ajax({
                url: this.base_url+'/accounts/logout',
                type: 'GET',
                success: function (result) {
                    if(result == 'true'){
                        self.buttonshow = false;
                        self.login=true;                      
                    }
                },
                failure: function (errMsg) {
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
                url: this.base_url+'/accounts/submit/changepin',
                type: 'POST',
                success: function (result) {
                    if(result == "true"){
                        self.error=true;
                self.error_msg="Pin successfully changed"; 
                    }

                    else{
                        self.error=true;
                        self.error_msg="Pin not changed try again later";
                    }
                   
                },
                failure: function (errMsg) {
                }
            })

        },

        serverpost(){
            var self = this;
            jQuery.ajax({
                data: {'acc-number' :this.acc_number, 'pin':this.pin },
                url: this.base_url+'/accounts/submit/login',
                type: 'POST',
                success: function (result) {
                    if(result == "true"){
                        
                        self.buttonshow = true;
                        self.login=false;                     
                    }else{
                        self.error_msg=result;
                        self.error = true;
                    }
                },
                failure: function (errMsg) {
                }
            })
            
        },

        cashWithdraw(withdrawAmount){
            var self=this;
            jQuery.ajax({
                data: {'amount' :withdrawAmount },
                url: this.base_url+'/transaction/submit/dashboard',
                type: 'POST',
                success: function (result) {
                    if(result==='false'){
                        self.error=true;
                        self.error_msg="Insufficient Account Balance";
                        return
                    }
                    window.location=window.location.origin+"/transaction/download?name=receipt";
                },
                failure: function (errMsg) {
                }
            })
        }
    }, 
    template:
    `
        <div class = "maincontainer">
        <center><h1> ATM SIMULATION</h1></center>
        <div class = "login" v-show ="login">
        <form method="POST" action="base_url/submit/login">
            <label for="AccountNumber"><b>Account Number</b></label>
            <input type="text" name="acc-number" v-model="acc_number" placeholder="Enter Account Number"  oninput="this.value = this.value.replace(/[^0-9.]/g, '')" name="email" required>
            <label for="pin"><b>Pin</b></label>
            <input type="text" v-model="pin" name="pin" placeholder="Enter password" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  required>
            <button class="button"  type="submit" value="submit" @click="auhthenticate">Submit</button>
            <span v-show ="error">{{error_msg}}</span>
        </form>
        </div>
        <div  v-show ="buttonshow" class="buttonshow" >
            <button class="button" @click="saving(), error=false, savings = !savings, withdrawal = false, change_pin = false">Savings</button>
            <button class="button" @click="savings = false,error=false, withdrawal = !withdrawal ,change_pin = false, login=false ">withdrawal</button>
            <button class="button" @click="change_pin = !change_pin,error=false, savings = false, withdrawal = false,login=false">Change Pin</button>
            <button class="button" @click="downloadStatement(), change_pin = false,error=false, savings = false, withdrawal = false,login=false">Download Statement</button>
            <button class="button logout" @click="logout() ,change_pin = false, error=false, savings = false, withdrawal = false,login=false">Logout</button>
        </div>
        <div v-show="savings" class="display" >
            <h2>Account Details </h2><br>
            <p> Account Number:{{acc_number}}</p>
            <p> Account Balance:{{account_savings}}</p>
        </div>
        <div v-show="change_pin" class="changepin" >
        <h2> Change your pin here</h2>
            <form method="POST" action="base_url/accounts/submit/changepin">
            <table class="pinblock">
    <tr>
        <td>
            Old Pin
        </td>
        <td>
            <input type="password" v-model="old_pin" name="old_pin" placeholder="Enter Old pin"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
        </td>
    </tr>
    <tr>
        <td>
            New Pin
        </td>
        <td>
            <input type="password" v-model="new_pin" name="new_pin" placeholder="Enter New pin"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
        </td>
    </tr>

    <tr>
        <td>
            Re-enter Pin
        </td>
        <td>
            <input type="password" v-model="re_pin" name="re_pin" placeholder="Re-Enter  pin"
                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
        </td>
    </tr>
</table>
        <button class="pinSubmit button"  type="submit" value="submit" @click="changePin">Submit</button>
            <span v-show ="error">{{error_msg}}</span>
        </form>

        </div>
        <div v-show="withdrawal">
        <center><span v-show ="error">{{error_msg}}</span></center>
        <div class = "withdrawal container">
        <div class="flex-container column">
            <button class="cashbox"  @click="cashWithdraw(2000)">$2000</button>
            <button  class="cashbox"    @click="cashWithdraw(1000)">$1000</button>
            <button  class="cashbox"    @click="cashWithdraw(500)">$500</button>
            <button  class="cashbox"   @click="cashWithdraw(100)">$100</button>
        </div>

        <div class="flex-container1 column">
        <button class="cashbox" @click="cashWithdraw(50)">$50</button>
        <button class="cashbox" @click="cashWithdraw(20)">$20</button>
        <button class="cashbox" @click="cashWithdraw(10)">$10</button>
        <button class="cashbox" @click="cashWithdraw(5)">$5</button>
        </div>    
        </div>
        </div>


    </div>
    </div>
    `,   
});

