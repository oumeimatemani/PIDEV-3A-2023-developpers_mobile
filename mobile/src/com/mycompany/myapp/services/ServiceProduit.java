/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.entities.Produit;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author khadija
 */
public class ServiceProduit {
     public ArrayList<Produit> produits;
    public static ServiceProduit instance ; 
    public boolean resultOK;
    private  ConnectionRequest req; 
 public static final String BASE_URL="http://127.0.0.1:8000";
 private ServiceProduit() {
        req = new ConnectionRequest() ; 
         }
    
    public static ServiceProduit getInstance() {
        if (instance == null)
        {
            instance = new ServiceProduit();
        }
         return instance;
    }
 
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
//            Logger.getLogger(ServiceOeuvre.class.getName()).log(Level.SEVERE, null, ex);
             
        }
          return produits;
 }
     public ArrayList<Produit> getAllOeuvres(){
          String url = BASE_URL+"/produitAPI";
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
        public void Supprimer(int id) {
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(BASE_URL+"/deleteProduitApi/"+id);
        con.setPost(false);
        con.addResponseListener((evt) -> {
            System.out.println(con.getResponseData());

        });
        NetworkManager.getInstance().addToQueueAndWait(con);

    }
       public boolean addProd (TextField nomProduit,TextField Desc,TextField prixProd ,TextField stock,Integer c)
    { 

       String url = BASE_URL+"/addProduitAPI?nomP="+nomProduit.getText()+"&descriptionP="+Desc.getText()+"&prixP="+prixProd.getText()+"&cat="+c+"&stock="+stock.getText();
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
           public boolean updateProd (TextField nomProduit,TextField Desc,TextField prixProd ,TextField stock,Integer c,int id)
    { 

       String url = BASE_URL+"/editProduitAPI/"+id+"?nomP="+nomProduit.getText()+"&descriptionP="+Desc.getText()+"&prixP="+prixProd.getText()+"&cat="+c+"&stock="+stock.getText();
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
           
   //Ajouter un produit au panier   
    public boolean addProdPanier (Integer idProduit)
    { 
       String url = BASE_URL+"/AjoutPanierJson/" + idProduit;
       req.setUrl(url);
       req.addResponseListener(new ActionListener<NetworkEvent>(){ 
           @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                 byte[] responseData = (byte[]) req.getResponseData();
                String responseMessage = new String(responseData);
                if(responseMessage.equals("Ce produit n'est plus disponible")){
                Dialog.show("ERROR",responseMessage,new Command("OK"));}
                else {Dialog.show("SUCCESS","Produit ajouté au panier",new Command("OK"));}
                req.removeResponseListener(this);
                
             }
    });
        System.out.println(""+resultOK);
       NetworkManager.getInstance().addToQueue(req);
      

        return resultOK;
    }
}
