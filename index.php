<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/Kassa-Me/':
        require 'home.php';
        break;
    case '/Kassa-Me/index':
        require 'home.php';
        break;	
    case '/Kassa-Me/index.php':
        require 'home.php';
        break;		
    case '/Kassa-Me/auth.php':
        require 'auth.php';
        break;
    case '/Kassa-Me/forgot':
        require 'forgot.php';
        break;	
    case '/Kassa-Me/forgot.php':
        require 'forgot.php';
        break;			
    case '/Kassa-Me/logout':
        require 'logout.php';
        break;	
    case '/Kassa-Me/logout.php':
        require 'logout.php';
        break;			
    case '/Kassa-Me/register':
        require 'register.php';
        break;	
    case '/Kassa-Me/register.php':
        require 'register.php';
        break;		
    case '/Kassa-Me/resetreq':
        require 'resetreq.php';
        break;	
    case '/Kassa-Me/resetreq.php':
        require 'resetreq.php';
        break;		
    case '/Kassa-Me/signup':
        require 'signup.php';
        break;	
    case '/Kassa-Me/account/':
        require 'account/index.php';
        break;	
    case '/Kassa-Me/account/index.php':
        require 'account/index.php';
        break;		
    case '/Kassa-Me/account/bank.php':
        require 'account/bank.php';
        break;	
    case '/Kassa-Me/account/get_access_token.php':
        require 'account/get_access_token.php';
        break;	
    case '/Kassa-Me/account/get_access_token':
        require 'account/get_access_token.php';
        break;			
    case '/Kassa-Me/account/logout':
        require 'account/logout.php';
        break;	
    case '/Kassa-Me/account/logout.php':
        require 'account/logout.php';
        break;			
    case '/Kassa-Me/account/profile':
        require 'account/profile.php';
        break;	
    case '/Kassa-Me/account/transaction':
        require 'account/transaction.php';
        break;		
    case '/Kassa-Me/account/profile':
        require 'account/profile.php';
        break;		
    case '/Kassa-Me/account/profile.php':
        require 'account/profile.php';
        break;	
    case '/Kassa-Me/account/verify':
        require 'account/verify.php';
        break;				
    case '/Kassa-Me/account/verify.php':
        require 'account/verify.php';
        break;	
    case '/Kassa-Me/account/transpay.php':
        require 'account/transpay.php';
        break;		
    case '/Kassa-Me/account/transpay':
        require 'account/transpay.php';
        break;			
    case '/Kassa-Me/account/transpaycc.php':
        require 'account/transpaycc.php';
        break;	
    case '/Kassa-Me/account/transpaycc':
        require 'account/transpaycc.php';
        break;			
    case '/Kassa-Me/account/transreq.php':
        require 'account/transreq.php';
        break;	
    case '/Kassa-Me/account/transreq':
        require 'account/transreq.php';
        break;		
    case '/Kassa-Me/account/transresend.php':
        require 'account/transresend.php';
        break;	
    case '/Kassa-Me/account/transresend':
        require 'account/transresend.php';
        break;			
    case '/Kassa-Me/account/upgradeAcc.php':
        require 'account/upgradeAcc.php';
        break;	
    case '/Kassa-Me/account/upgradeAcc':
        require 'account/upgradeAcc.php';
        break;		
    case '/Kassa-Me/account/transaction-new':
        require 'account/transaction-new.php';
        break;	
    case '/Kassa-Me/account/transaction-new.php':
        require 'account/transaction-new.php';
        break;	
    case '/Kassa-Me/account/test.php':
        require 'account/test.php';
        break;		
    case '/Kassa-Me/account/bowner.php':
        require 'account/bowner.php';
        break;		
    case '/Kassa-Me/account/bowner-certify.php':
        require 'account/bowner-certify.php';
        break;	
    case '/Kassa-Me/account/upload.php':
        require 'account/upload.php';
        break;			
    default:
		//print_r($_SERVER['REQUEST_URI']);
        http_response_code(404);
        exit('Not Found');
}