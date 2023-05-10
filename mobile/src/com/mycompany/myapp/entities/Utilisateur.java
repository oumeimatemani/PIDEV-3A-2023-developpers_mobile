/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.myapp.entities;

/**
 *
 * @author khadija
 */
public class Utilisateur {

    protected int id;
    protected String username;
    protected String password;
    protected String verifpassword;
    protected String email;
    protected String roles;
    protected boolean role;
    protected boolean isVerfied;

    public Utilisateur() {
    }
 public Utilisateur( String username, String password, String verifpassword, String email) {
      
        this.username = username;
        this.password = password;
        this.verifpassword = verifpassword;
        this.email = email;
    }
    public Utilisateur(int id, String username, String password, String verifpassword, String email) {
        this.id = id;
        this.username = username;
        this.password = password;
        this.verifpassword = verifpassword;
        this.email = email;
    }

    public Utilisateur(int id, String username, String password, String verifpassword, String email, String roles, boolean role, boolean isVerfied) {
        this.id = id;
        this.username = username;
        this.password = password;
        this.verifpassword = verifpassword;
        this.email = email;
        this.roles = roles;
        this.role = role;
        this.isVerfied = isVerfied;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getVerifpassword() {
        return verifpassword;
    }

    public void setVerifpassword(String verifpassword) {
        this.verifpassword = verifpassword;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getRoles() {
        return roles;
    }

    public void setRoles(String roles) {
        this.roles = roles;
    }

    public boolean isRole() {
        return role;
    }

    public void setRole(boolean role) {
        this.role = role;
    }

    public boolean isIsVerfied() {
        return isVerfied;
    }

    public void setIsVerfied(boolean isVerfied) {
        this.isVerfied = isVerfied;
    }
@Override
    public String toString() {
        return "User:" + ", username=" + username + ", email=" + email ;
    }


}
