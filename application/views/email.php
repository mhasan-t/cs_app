

<html>
    <head>
        <title>Vulnerable Login Page</title>
        
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
                flex-direction : column;
                gap : 30px;
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
            <?php echo $this->session->flashdata('email_sent'); ?>


        
            <?php echo validation_errors(); ?>
            <?php echo form_open('login/verify_email') ?>
                <div class="form-container">
                    <div class="input-container">
                        <label for="code"><b>Code : </b></label>
                        <input type="text" placeholder="Enter code from email" name="code" required>
                    </div>
                    
                    <button type="submit">Submit</button>
                </div>
            
            </form>
        </div>

    

    

</html>
