const mp = new MercadoPago('YOUR_PUBLIC_KEY');
const bricksBuilder = mp.bricks();
      
mp.bricks().create("wallet", "wallet_container", {
   initialization: {
       preferenceId: "<wallet_container>",
   },
});