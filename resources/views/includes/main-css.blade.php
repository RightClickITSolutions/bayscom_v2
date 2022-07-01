        <!-- JQUERY: -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

        <!-- BEGIN: VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/vendors.min.css') }}">
        <!-- END: VENDOR CSS-->
        <!-- BEGIN: VENDOR CSS-->
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/sweetalert/sweetalert.css') }}"> --}}
        <!-- END: VENDOR CSS-->
        <!-- BEGIN: Page Level CSS-->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/themes/vertical-gradient-menu-template/materialize.css') }}">
            {{-- href="{{ asset('app-assets/css/themes/vertical-gradient-menu-template/materialize.cs') }}s"> --}}
        <link rel="stylesheet" type="text/css"
            href="{{ asset('app-assets/css/themes/vertical-gradient-menu-template/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/user-profile-page.css') }}">
        <!-- END: Page Level CSS-->
        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/custom/custom.css') }}">
        <!-- END: Custom CSS-->
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <style>
            .negative {
                color: #ba0006 !important;
            }
            .positive {
                color: #009211 !important;
            }
            td.action-btn-row a{
                display: inline !important;
                margin: 5px !important;
            }
            a.btn-edit{
                height: 40px;
                border-radius: 5px;
                padding: 5px;
                width: 100px;
                background-color: blue;
                color: white;
                font-size: 14px;
            }
            a.btn-delete{
                height: 40px;
                border-radius: 5px;
                padding: 5px;
                width: 100px;
                background-color: red;
                color: white;
                font-size: 14px;
            }
            .delete-confirmation{
                width: 50%;
                height: auto;
                /* border: 1px solid red; */
                text-align: center;
                margin-left: 250px !important;
                margin-top: 80px !important;
                box-shadow: 5px 10px 12px #d2d2d2;
            }
            .btn-yes{
                background-color: #C82333;
            }
            .btn-yes:hover{
                background-color: #d2d2d2;
                color: #000;
            }
            .btn-no{
                background-color: #218838;
            }
            .btn-no:hover{
                background-color: #d2d2d2;
                color: #000;
            }
            .delete-confirmation h4{
                font-size: 20px;
                font-weight: lighter;
                color: red;
            }
            .delete-confirmation h4 span{
                font-weight: 600;
            }
            .delete-confirmation ul{
                width: auto;
                height: auto;
                /* font-weight: lighter !important; */
                color: #000000
            }
            .delete-confirmation ul li{
                margin-bottom: 10px;
                font-size: 18px;
                /* font-weight: lighter !important; */
            }
            .delete-confirmation ul li span{
                font-weight: lighter;
                width: auto;
                height: auto;
            }
            .edit_customer_form{
                width: auto;
                height: auto;
                border-radius: 5px;
                box-shadow: 5px 10px 12px #d2d2d2;
                padding: 30px !important;
                margin-left: 250px !important;
            }
            .header-customer-form{
                padding-bottom: 50px;
            }
            .edit_customer_form form div.form-control input{
                height: 35px !important;
                border: 1px solid #cccccc;
                color: rgb(134, 134, 134, 0.9);
                border-radius: 10px;
                margin-bottom: 10px;
                padding: 5px;
            }
            .edit_customer_form form div.form-control button.btn{
                width: 100%;
                height: 35px;
                margin-left: 130px;
                margin-top: 10px;
                background-color: #E77828 !important;
                /* color: #fff !important; */
            }
            .edit_customer_form form div.form-control button.btn h6{
                color: #fff !important
            }
            .edit_customer_form div.control-form label{
                font-size: 18px !important;
                color: rgb(134, 134, 134, 0.9) !important;
            }
            .btn-edit-station{
                background-color: #0069D9 !important;
            }
            .btn-delete-station{
                background-color: #C82333 !important;
            }

            .table.dataTable tbody{
                background-color: black !important;
            }
           .side-nav-bayscom{
               background-color: #00550A !important;
           }
           .brand-sidebar{
               background: #00550A !important;
           }
           .fixed-action-btn{
               display: none !important;
           }
           .brand-sidebar span.logo-text{
               color: #FF9800 !important;
               font-weight: 700;
           }
           ul.leftside-navigation li i.material-icons{
               color: #FF9800 !important;
           }
           .breadcrumbs-bg{
               background-color: #00550A !important;
               color: #fff !important;
           }
           h5.breadcrumbs-title{
               color: #fff;
           }
           h3{
               color: #000;
           }
           .breadcrumbs-page{
               height: 50px;
               border-radius: 10px;
           }
           .breadcrumbs-page p.breadcrumbs-heading-tag{
               color: #000;
           }
           p.breadcrumbs-heading-tag span.span-page-name{
               color: #E77828 !important;
               font-weight: 900;
           }
        </style>


