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
import java.util.ArrayList;
import java.util.Vector;



/**
 *
 * @author khadija
 */
public class EditProduitForm extends BaseFormBack {

    public EditProduitForm(Form previous,Resources res,int id) {
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
        Container radioContainer = new Container(flow);
        for(int iter = 0 ; iter < rbs.length ; iter++) {
            rbs[iter] = RadioButton.createToggle(unselectedWalkthru, bg);
            rbs[iter].setPressedIcon(selectedWalkthru);
            rbs[iter].setUIID("Label");
            radioContainer.add(rbs[iter]);
        }
                
        rbs[0].setSelected(true);
        swipe.addSelectionListener((i, ii) -> {
            if(!rbs[ii].isSelected()) {
                rbs[ii].setSelected(true);
            }
        });
        
        Component.setSameSize(radioContainer, spacer1, spacer2);
        add(LayeredLayout.encloseIn(swipe, radioContainer));
        
          swipe.setUIID("Container");
        swipe.getContentPane().setUIID("Container");
        swipe.hideTabs();
              setTitle("Add produit");
        setLayout(BoxLayout.yCenter());
 TextField tfNomProd = new TextField(""," Nom produit ");
        TextField tfdesc = new TextField("","Description ");

        TextField tfprix= new TextField("", " Prix");
                TextField tfstock= new TextField("", " stock");

        Vector<Integer> vectorCommande;
        Vector<String> vectorCommandenom;
        vectorCommande = new Vector();
        vectorCommandenom = new Vector();
        ArrayList<Categorie> enn = ServiceCategorie.getInstance().getAllOeuvres();
        for (Categorie eyy : enn) {
           // vectorCommandenom.add(eyy.getNomCategorie());
            vectorCommande.add(eyy.getId_categorie());
        }

        ComboBox<Integer> commandes = new ComboBox<>(vectorCommande);
        commandes.setUIID("ComboBox");
    

        Button btnValider = new Button("Edit Produit");
     
        btnValider.addActionListener(new ActionListener() {
             @Override
             public void actionPerformed(ActionEvent evt) {
                 if ((tfNomProd.getText().length()==0)||(tfdesc.getText().length()==0)||(tfprix.getText().length()==0))
                    Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
                 else {
                    try {
                     
                        
                        if(ServiceProduit.getInstance().updateProd(tfNomProd, tfdesc,tfprix ,tfstock,commandes.getSelectedItem(),id))
                            Dialog.show("Success","Connection accepted",new Command("OK"));
                 
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", "price must be a number", new Command("OK"));
                    
                   }
  Dialog.show("Success","Connection accepted",new Command("OK"));
                 }}
        });
          addAll(tfNomProd,tfdesc,tfprix,tfstock);
                  addStringValue("Categorie", commandes); 
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