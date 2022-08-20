


<html>
    <head>
        <title>Choose 2FA</title>
        
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
                gap : 10px;
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
            <a href="/cs_app/phone"><button>Get SMS</button></a>
            <a href="/cs_app/email"><button>Get E-Mail</button></a>
        </div>

    

    

</html>
