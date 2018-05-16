<?php
if(!defined("EXEC"))
	return;

//  chi e' che crea l-ordine, e chi se se lo ricorda??? il cestino?? il cliente?? 


interface EMetodoPagamento{
    
    privare $valuta=euro;
    
    
    public function paga();
    public function sceglivaluta();

}
