/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;

import com.codename1.components.ScaleImageLabel;
import com.codename1.ui.Button;
import com.codename1.ui.ButtonGroup;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Command;
import com.codename1.ui.Component;
import static com.codename1.ui.Component.BOTTOM;
import static com.codename1.ui.Component.CENTER;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Graphics;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.RadioButton;
import com.codename1.ui.Tabs;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.LayeredLayout;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Categorie;
import com.mycompany.myapp.services.ServiceCategorie;

import com.mycompany.myapp.services.ServiceProduit;
import com.mycompany.myapp.services.ServicePanier;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Vector;



/**
 *
 * @author user
 */
public class EditCommandeForm extends BaseFormBack {

    public EditCommandeForm(Form previous,Resources res)  throws IOException{
         super("liste des produits", BoxLayout.y());
        
        Toolbar tb = new Toolbar(true);
        setToolbar(tb);
        getTitleArea().setUIID("Container");
        setTitle("Add produit");
        getContentPane().setScrollVisible(false);
        
        super.addSideMenu(res);
        //tb.addSearchCommand(e -> {});
                Tabs swipe = new Tabs();
                        Label spacer1 = new Label();
        Label spacer2 = new Label();

        addTab(swipe,  spacer1);
          swipe.setUIID("Container");
        swipe.getContentPane().setUIID("Container");
        swipe.hideTabs();
        ButtonGroup bg = new ButtonGroup();
        int size = Display.getInstance().convertToPixels(1);
        Image unselectedWalkthru = Image.createImage(size, size, 0);
        Graphics g = unselectedWalkthru.getGraphics();
        g.setColor(0xffffff);
        g.setAlpha(100);
        g.setAntiAliased(true);
        g.fillArc(0, 0, size, size, 0, 360);
        Image selectedWalkthru = Image.createImage(size, size, 0);
        g = selectedWalkthru.getGraphics();
        g.setColor(0xffffff);
        g.setAntiAliased(true);
        g.fillArc(0, 0, size, size, 0, 360);
        RadioButton[] rbs = new RadioButton[swipe.getTabCount()];
        FlowLayout flow = new FlowLayout(CENTER);
        flow.setValign(BOTTOM);

          swipe.setUIID("Container");
        swipe.getContentPane().setUIID("Container");
        swipe.hideTabs();
         setTitle("Merci d'entrer vos coordonnées !");
        setLayout(BoxLayout.yCenter());
        TextField tfNomClient = new TextField(""," Nom et prénom ");
        TextField tfMail = new TextField("","Adresse e-mail ");

        TextField tfAdresse = new TextField("", " Adresse de livraison");

        Vector<Integer> vectorCommande;
        Vector<String> vectorCommandenom;
        vectorCommande = new Vector();
        vectorCommandenom = new Vector();
        

        ComboBox<Integer> commandes = new ComboBox<>(vectorCommande);
        commandes.setUIID("ComboBox");
    

        Button btnValider = new Button("Valider la commande");
     
        btnValider.addActionListener( new ActionListener() {
             @Override
             public void actionPerformed(ActionEvent evt) {
                 if ((tfNomClient.getText().length()==0)||(tfMail.getText().length()==0)||(tfAdresse.getText().length()==0))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                 else {
                    try {
                    
                        if(ServicePanier.getInstance().passerCommande(tfNomClient, tfMail,tfAdresse))
                            Dialog.show("Success","Commande validée",new Command("OK"));
                          // Navigate to CommandeForm
                          CommandeForm commandeForm = new CommandeForm(res); // Create an instance of your CommandeForm class
                           commandeForm.show(); // Show the CommandeForm
                 
                    } catch (Exception e) {
                        Dialog.show("ERROR", "Error validating", new Command("OK"));
                    
                   }
 // Dialog.show("Success","Connection accepted",new Command("OK"));
                 }}
        });
          addAll(tfNomClient,tfMail,tfAdresse);
   
                  addAll(btnValider);
         getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
    
    }
    private void addTab(Tabs swipe, Label spacer) {
        int size = Math.min(Display.getInstance().getDisplayWidth(), Display.getInstance().getDisplayHeight());
     
        Label overlay = new Label(" ", "ImageOverlay");
        
        Container page1 = 
            LayeredLayout.encloseIn(
                overlay,
                BorderLayout.south(
                    BoxLayout.encloseY(
                           
                            spacer
                        )
                )
            );

        swipe.addTab("", page1);
    }
          private void addStringValue(String s, Component v) {
        add(BorderLayout.west(new Label(s, "PaddedLabel")).
                add(BorderLayout.CENTER, v));
        add(createLineSeparator(0xeeeeee));
    }
}