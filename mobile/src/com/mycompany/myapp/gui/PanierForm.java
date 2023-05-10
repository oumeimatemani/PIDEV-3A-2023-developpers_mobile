package com.mycompany.myapp.gui;

import com.codename1.ui.Button;
import com.codename1.ui.ButtonGroup;
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
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.LayeredLayout;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Produit;
import com.mycompany.myapp.services.ServiceProduit;
import com.mycompany.myapp.services.ServicePanier;
import java.io.IOException;
import java.util.ArrayList;


public class PanierForm extends BaseFormBack {

    public PanierForm(Form previous,Resources res) throws IOException {
          super("produit", BoxLayout.y());
        Toolbar tb = new Toolbar(true);
        setToolbar(tb);
        getTitleArea().setUIID("Container");
        setTitle("Expositions");
        getContentPane().setScrollVisible(false);
        
        super.addSideMenu(res);
        //tb.addSearchCommand(e -> {});
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
              setTitle("Add produit");
        setLayout(BoxLayout.yCenter());
          ArrayList<Produit> list;
        list = new ArrayList<>();
        list = ServicePanier.getInstance().getAllOeuvres();

        ArrayList<Produit> panier = new ArrayList<Produit>();

        for ( Produit p : list) {
            
              
                  Label i = new Label();
                  
                 
         Label spl = new Label("Product name: " + "  " + p.getNom_produit()); 
         spl.getAllStyles().setFgColor(0x00000);
         Label spl2 = new Label("Product price: " + "  " + p.getPrix_produit()); 
         spl2.getAllStyles().setFgColor(0x00000);
        
          Label spl7 = new Label("Product Description: " + "  " + p.getDescription());
          spl7.getAllStyles().setFgColor(0x00000);
         Label spl5 = new Label("Product Stock: " + "  " + p.getStock());
         spl5.getAllStyles().setFgColor(0x00000);
     


         Button sup = new Button("Delete");


             
                sup.addActionListener((evt) -> {
                   ServicePanier.getInstance().Supprimer(p.getId_produit());
                    System.out.println("Product deleted successfully");
                    Dialog.show("Alert", "Delete Product ?", new Command("OK"));
                    Dialog.show("Success", "Product deleted successfully", new Command("OK"));
                     /*Message m = new Message("Your Product has been deleted successfully !");
                        Display.getInstance().sendMessage(new String[] {"khadija.chaari@esprit.tn"}, "Confirmation", m);
                    */});
        addAll(spl,spl2,spl5,spl7,sup)
                ;}
       Button passerCmd = new Button("Passer la commande");
        passerCmd.addActionListener((evt) -> {
            try{
                        new EditCommandeForm(this.getComponentForm(),res).show();
                          }catch(IOException e){e.printStackTrace();};
                    });
       
        add(passerCmd);
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
