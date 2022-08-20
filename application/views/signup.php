

<html>
    <head>
        <title>Sign Up</title>
        
        <style>
            .form-container{
                width : 400px;
                display : flex;
                justify-content : center;
                align-items : center;
                flex-direction : column;
            }
            .container {
                width : 100vw;
                height : 100vh;
                display : flex;
                justify-content : center;
                align-items : center;
                flex-direction : row;
            }
            .input-container {
                display: flex;
                gap : 10px;
                margin-bottom : 10px
            }
            textarea:focus, input:focus{
                outline: 1px solid #2bc1fc;
            }
            textarea, input{
                border : 1px solid #dbdbdb;
                border-radius : 10px;
                padding : 5px;
            }

            button {
                padding : 5px 15px;
                border-radius : 8px;
                background-color : #2bc1fc;
                border : 1px solid #2bc1fc;
                color : white;
            }

        </style>
    </head>


        <div class="container">
            <?php echo validation_errors(); ?>

            <?php echo form_open('login/signup') ?>
                <div class="form-container">
                    <div class="input-container">
                        <label for="username"><b>Username : </b></label>
                        <input type="text" placeholder="Enter Username" name="username" required>
                    </div>
                    
                    <div class="input-container">
                        <label for="passwd"><b>Password : </b></label>
                        <input type="password" placeholder="Enter Password" name="passwd" required>
                    </div>
                    <div class="input-container">
                        <label for="phone"><b>Phone : </b></label>
                        <input type="phone" placeholder="Enter Phone Number" name="phone" required>
                    </div>
                    <div class="input-container">
                        <label for="email"><b>E-Mail : </b></label>
                        <input type="email" placeholder="Enter E-mail address" name="email" required>
                    </div>
                    <button type="submit">Sign Up</button>
                </div>
            
            </form>
        </div>

    

    

</html>
