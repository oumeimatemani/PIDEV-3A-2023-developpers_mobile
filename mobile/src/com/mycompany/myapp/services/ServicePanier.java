
package com.mycompany.myapp.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Produit;
import static com.mycompany.myapp.services.ServiceProduit.BASE_URL;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;


public class ServicePanier {
    public ArrayList<Produit> produits;
    public static ServicePanier instance ; 
    public boolean resultOK;
    private  ConnectionRequest req; 
 public static final String BASE_URL="http://127.0.0.1:8000"; 

private ServicePanier() {
        req = new ConnectionRequest() ; 
         }
    
    public static ServicePanier getInstance() {
        if (instance == null)
        {
            instance = new ServicePanier();
        }
         return instance;
    }
 
    
    //ajouter un produits
   public ArrayList<Produit> parseProduits(String jsonText){
        try {
            produits= new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> ProduitListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
           List< Map<String,Object>> list =(List< Map<String,Object>>) ProduitListJson.get("root");
           for ( Map<String,Object> obj: list){
             Produit p = new Produit();
             float id = Float.parseFloat(obj.get("id").toString());
             float stock = Float.parseFloat(obj.get("stock").toString());

             p.setId_produit((int)id);
           p.setNom_produit(obj.get("nomP").toString());
             p.setDescription(obj.get("descriptionP").toString());
             p.setPrix_produit((double) obj.get("prixP"));
             p.setStock((int) stock);
             produits.add(p);
         
        } }
           catch (IOException ex) {
    // Logger.getLogger(ServiceOeuvre.class.getName()).log(Level.SEVERE, null, ex);
             
        }
          return produits;
 }
 
   //afficher les produits
     public ArrayList<Produit> getAllOeuvres(){
          String url = BASE_URL+"/panierJSON";
        req.setUrl(url);
        req.setPost(false);

                System.out.println(url);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                produits = parseProduits(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return produits;
    }

    public boolean passerCommande (TextField tfNomClient,TextField tfMail,TextField tfAdresse)
    { 

       String url = BASE_URL+"/PasserCommandeAPI?mailClient="+tfMail.getText()+"&adresseLivraison="+tfAdresse.getText()+"&nomClient="+tfNomClient.getText();
       req.setUrl(url);
       req.addResponseListener(new ActionListener<NetworkEvent>(){ 
           @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
             }
    });
        System.out.println(""+resultOK);
       NetworkManager.getInstance().addToQueue(req);
        return resultOK;
    }
   
    //supprimer un produits
     public void Supprimer(int id) {
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(BASE_URL+"/suppressionProduitDuPanierAPI/"+id);
        con.setPost(false);
        con.addResponseListener((evt) -> {
            System.out.println(con.getResponseData());

        });
        NetworkManager.getInstance().addToQueueAndWait(con);

    }
        
 
   


}
