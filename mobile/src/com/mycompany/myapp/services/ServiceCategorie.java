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
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionListener;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;


/**
 *
 * @author khadija
 */
public class ServiceCategorie {
    public ArrayList<Categorie> categories;
    public static ServiceCategorie instance ; 
    public boolean resultOK;
    private  ConnectionRequest req; 
 public static final String BASE_URL="http://127.0.0.1:8000";
 private ServiceCategorie() {
        req = new ConnectionRequest() ; 
         }
    
    public static ServiceCategorie getInstance() {
        if (instance == null)
        {
            instance = new ServiceCategorie();
        }
         return instance;
    }
 
 public ArrayList<Categorie> parseCategories(String jsonText){
        try {
            categories= new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> CategorieListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
           List< Map<String,Object>> list =(List< Map<String,Object>>) CategorieListJson.get("root");
           for ( Map<String,Object> obj: list){
             Categorie c = new Categorie();
             float id = Float.parseFloat(obj.get("id").toString());
             
             c.setId_categorie((int)id);
             c.setNom_categorie(obj.get("nomC").toString());
             c.setType_categorie(obj.get("descriptionCat").toString());
             c.setDate(obj.get("dateCreation").toString());
             
             categories.add(c);
         
        } }
           catch (IOException ex) {
//            Logger.getLogger(ServiceOeuvre.class.getName()).log(Level.SEVERE, null, ex);
             
        }
          return categories;
 }
     public ArrayList<Categorie> getAllOeuvres(){
          String url = BASE_URL+"/categorieAPI";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                categories = parseCategories(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return categories;
    }
        public void Supprimer(int id) {
        ConnectionRequest con = new ConnectionRequest();
        con.setUrl(BASE_URL+"/deleteCatApi/"+id);
        con.setPost(false);
        con.addResponseListener((evt) -> {
            System.out.println(con.getResponseData());

        });
        NetworkManager.getInstance().addToQueueAndWait(con);

    }
       public boolean addcateg (TextField Nomcategorie,TextField Typecategorie ,Date d)
    { 

       String url = BASE_URL+"/addCategorieAPI?nom_categorie="+Nomcategorie.getText()+"&desc_categorie="+Typecategorie.getText()+"&date="+d;
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
           public boolean updateCateg (TextField Nomcategorie,TextField Typecategorie,int id,Date d)
    { 

       String url = BASE_URL+"/editCatAPI/"+id+"?nom_categorie="+Nomcategorie.getText()+"&desc_categorie="+Typecategorie.getText()+"&date="+d;
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

}

