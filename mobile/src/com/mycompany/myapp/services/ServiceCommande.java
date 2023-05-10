
package com.mycompany.myapp.services;
import com.codename1.components.WebBrowser;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BorderLayout;

import com.codename1.io.FileSystemStorage;
import com.codename1.io.Storage;
import com.codename1.io.Util;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.events.ActionListener;
import java.io.IOException;
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
import com.mycompany.myapp.entities.Commande;
import static com.mycompany.myapp.services.ServicePanier.BASE_URL;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionListener;


public class ServiceCommande {
    public ArrayList<Commande> commandes;
    public static ServiceCommande instance ; 
    public boolean resultOK;
    private  ConnectionRequest req; 
 public static final String BASE_URL="http://127.0.0.1:8000";
 
 
 private ServiceCommande() {
        req = new ConnectionRequest() ; 
         }
    
    public static ServiceCommande getInstance() {
        if (instance == null)
        {
            instance = new ServiceCommande();
        }
         return instance;
    }
 
    
    //ajouter un produits
   public ArrayList<Commande> parseProduits(String jsonText){
        try {
            commandes= new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> ProduitListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
           List< Map<String,Object>> list =(List< Map<String,Object>>) ProduitListJson.get("root");
           for ( Map<String,Object> obj: list){
             Commande c = new Commande();
             float id = Float.parseFloat(obj.get("id").toString());

            c.setId_commande((int)id);
           c.setNomClient(obj.get("nomClient").toString());
             c.setMailClient(obj.get("mailClient").toString());
            c.setAdresseLivraison( obj.get("adresseLivraison").toString());
             c.setStatus(obj.get("status").toString());
             commandes.add(c);
         
        } }
           catch (IOException ex) {
    // Logger.getLogger(ServiceOeuvre.class.getName()).log(Level.SEVERE, null, ex);
             
        }
          return commandes;
 }
 
   //afficher les produits
     public ArrayList<Commande> getAllOeuvres(){
          String url = BASE_URL+"/CommandeJSON";
        req.setUrl(url);
        req.setPost(false);

                System.out.println(url);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                commandes = parseProduits(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return commandes;
    }
     
    public void genererPdf(int id)
    { 

       String url = BASE_URL+"/pdfAPI/"+id ;
      
//    Form form = new Form("PDF Viewer");
//    form.setLayout(new BorderLayout());
//
//    WebBrowser webBrowser = new WebBrowser();
//    form.add(BorderLayout.CENTER, webBrowser);
//
//    webBrowser.setURL(url);
//
//    form.show();
  }


}
