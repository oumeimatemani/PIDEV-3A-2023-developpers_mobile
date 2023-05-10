/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities;

import java.util.Date;

/**
 *
 * @author khadija
 */
public class Produit {
    private int id_produit;
    private String nom_produit;
    private String description;
    private double prix_produit;
    private int Qte_produit;
    private int Stock;

    public Produit() {
    }


    public int getId_produit() {
        return id_produit;
    }

    public void setId_produit(int id_produit) {
        this.id_produit = id_produit;
    }

    public String getNom_produit() {
        return nom_produit;
    }

    public void setNom_produit(String nom_produit) {
        this.nom_produit = nom_produit;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public double getPrix_produit() {
        return prix_produit;
    }

    public void setPrix_produit(double prix_produit) {
        this.prix_produit = prix_produit;
    }



    public int getQte_produit() {
        return Qte_produit;
    }

    public void setQte_produit(int Qte_produit) {
        this.Qte_produit = Qte_produit;
    }

    public int getStock() {
        return Stock;
    }

    public void setStock(int Stock) {
        this.Stock = Stock;
    }

    @Override
    public String toString() {
        return "Produit{" + "id_produit=" + id_produit + ", nom_produit=" + nom_produit + ", description=" + description + ", prix_produit=" + prix_produit + ", Qte_produit=" + Qte_produit + ", Stock=" + Stock + '}';
    }


 
}
