package com.mycompany.myapp.entities;

import java.util.Collection;
import java.util.Date;

public class Panier {
    private int id_panier;
    private Collection produits;  
    private int quantite;
    private Date DateAjout ;
    
    public Panier() {
     
    }
    public Panier(int id_panier, Collection produits, int quantite, Date DateAjout) {
        this.id_panier = id_panier;
        this.produits = produits;
        this.quantite = quantite;
        this.DateAjout = DateAjout;
    }

    public int getId_panier() {
        return id_panier;
    }

    public void setId_panier(int id_panier) {
        this.id_panier = id_panier;
    }

    public Collection getProduits() {
        return produits;
    }

    public void setProduits(Collection produits) {
        this.produits = produits;
    }

    public int getQuantite() {
        return quantite;
    }

    public void setQuantite(int quantite) {
        this.quantite = quantite;
    }

    public Date getDateAjout() {
        return DateAjout;
    }

    public void setDateAjout(Date DateAjout) {
        this.DateAjout = DateAjout;
    }

    @Override
  public String toString() {
        return "Panier{" + "id_panier : " + id_panier + ", Produits : " + produits + ", quantité des produits dans le panier : " + quantite + ", Date d'ajout de produit dans le panier=" + DateAjout +'}';
    }    

    public void setPrixTotal(double parseDouble) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
    
    
  
    
}
