package com.mycompany.myapp.entities;

import java.util.Date;

public class Commande {
    private int id_commande;
    private Date dateCommande ;
    private String nomClient ;
    private String mailClient ;
    private String adresseLivraison;
    private Float prixTotal ;
    private String status ;
    private Panier panier;

    
     public Commande() {
        
    }
    public Commande(int id_commande, Date dateCommande, String nomClient, String mailClient, String adresseLivraison, Float prixTotal, String status) {
        this.id_commande = id_commande;
        this.dateCommande = dateCommande;
        this.nomClient = nomClient;
        this.mailClient = mailClient;
        this.adresseLivraison = adresseLivraison;
        this.prixTotal = prixTotal;
        this.status = status;
    }

    public int getId_commande() {
        return id_commande;
    }

    public void setId_commande(int id_commande) {
        this.id_commande = id_commande;
    }

    public Date getDateCommande() {
        return dateCommande;
    }

    public void setDateCommande(Date dateCommande) {
        this.dateCommande = dateCommande;
    }

    public String getMailClient() {
        return mailClient;
    }

    public void setMailClient(String mailClient) {
        this.mailClient = mailClient;
    }

    public String getAdresseLivraison() {
        return adresseLivraison;
    }

    public void setAdresseLivraison(String adresseLivraison) {
        this.adresseLivraison = adresseLivraison;
    }

    public Float getPrixTotal() {
        return prixTotal;
    }

    public void setPrixTotal(Float prixTotal) {
        this.prixTotal = prixTotal;
    }
    public void setNomClient(String nomClient) {
        this.nomClient = nomClient;
    }

    public String getNomClient() {
        return this.nomClient;
    }
        
    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public Panier getPanier() {
        return panier;
    }

    public void setPanier(Panier panier) {
        this.panier = panier;
    }
    
    
     @Override
  public String toString() {
        return "Commande: {" + "id_commande : " + id_commande + ", Date: " + dateCommande + ", Nom de Client : " + nomClient + ", adresse mail de Client : " + mailClient +
     ", adresse de Livraison: " + adresseLivraison + ", Prix Total: " + prixTotal + " , Status :" + " , Panier :"  + '}';
    }   

}

