/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.gui;


import com.codename1.components.ImageViewer;
import com.codename1.components.ScaleImageLabel;
import com.codename1.components.SpanLabel;
import com.codename1.io.FileSystemStorage;
import com.codename1.io.Log;
import com.codename1.messaging.Message;
import com.codename1.ui.Button;
import com.codename1.ui.ButtonGroup;
import com.codename1.ui.Command;
import com.codename1.ui.Component;
import static com.codename1.ui.Component.BOTTOM;
import static com.codename1.ui.Component.CENTER;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Graphics;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.RadioButton;
import com.codename1.ui.Tabs;
import com.codename1.ui.Toolbar;
import com.codename1.ui.URLImage;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.LayeredLayout;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.spinner.Picker;
import com.codename1.ui.util.ImageIO;
import com.codename1.ui.util.Resources;

import com.mycompany.myapp.entities.Categorie;
import java.util.ArrayList;
import static java.util.Collections.list;
import java.io.IOException;
import java.io.OutputStream;

import com.mycompany.myapp.services.ServiceCategorie;

/**
 *
 * @author khadija
 */
public class ListCategoriesForm extends BaseFormBack {
     public ListCategoriesForm(Form previous,Resources res) throws IOException {
          super("categorie", BoxLayout.y());
        Toolbar tb = new Toolbar(true);
        setToolbar(tb);
        getTitleArea().setUIID("Container");
        setTitle("Expositions");
        getContentPane().setScrollVisible(false);
        
        super.addSideMenu(res);
       
                Tabs swipe = new Tabs();
                        Label spacer1 = new Label();
        Label spacer2 = new Label();

        addTab(swipe, spacer1);
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
              setTitle("Add categorie");
        setLayout(BoxLayout.yCenter());
          ArrayList<Categorie> list;
        list = new ArrayList<>();
        list = ServiceCategorie.getInstance().getAllOeuvres();

        for ( Categorie c : list) {
            
              
                  Label i = new Label();
                  
                 
         Label spl = new Label("categorie name: " + "  " + c.getNom_categorie()); 
         spl.getAllStyles().setFgColor(0x00000);
         Label spl2 = new Label("categorie description: " + "  " + c.getType_categorie());
         spl2.getAllStyles().setFgColor(0x00000);

                Label sp2 = new Label("date creation: " + "  " + c.getDate());
         sp2.getAllStyles().setFgColor(0x00000);

         Button sup = new Button("Delete");
                  Button upd = new Button("Update");

             
                sup.addActionListener((evt) -> {
                   ServiceCategorie.getInstance().Supprimer(c.getId_categorie());
                    System.out.println("categorie deleted successfully");
                    Dialog.show("Alert", "Delete categorie ?", new Command("OK"));
                    Dialog.show("Success", "categorie deleted successfully", new Command("OK"));
                     /*Message m = new Message("Your categorie has been deleted successfully !");
                        Display.getInstance().sendMessage(new String[] {"khadija.chaari@esprit.tn"}, "Confirmation", m);
                   */ });
                 upd.addActionListener((evt) -> {
                        new EditCategorieForm(this.getComponentForm(),res,c.getId_categorie()).show();
                    });
        addAll(spl,spl2,sp2,sup,upd)
                ;}
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
    }
    
    private void addTab(Tabs swipe,  Label spacer) {
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
}
