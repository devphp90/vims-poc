CREATE TABLE vims_action (
                act_id INT AUTO_INCREMENT NOT NULL,
                act_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (act_id)
);


CREATE TABLE vims_rule (
                rule_id INT AUTO_INCREMENT NOT NULL,
                rule_name VARCHAR(255) NOT NULL,
                rule_lvl INT(11) NOT NULL,
                rule_var1 DOUBLE NOT NULL,
                rule_var2 DOUBLE NOT NULL,
                rule_var3 DOUBLE NOT NULL,
                rule_var4 DOUBLE NOT NULL,
                rule_var5 DOUBLE NOT NULL,
                rule_act1 INT(11) NOT NULL,
                rule_act2 INT(11) NOT NULL,
                rule_act3 INT(11) NOT NULL,
                PRIMARY KEY (rule_id)
);


CREATE TABLE vims_role (
                role_id INT AUTO_INCREMENT NOT NULL,
                role_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (role_id)
);


CREATE TABLE vims_user (
                user_id INT AUTO_INCREMENT NOT NULL,
                username VARCHAR(255) NOT NULL,
                pwd VARCHAR(255) NOT NULL,
                role_id INT(11) NOT NULL,
                created DATETIME NOT NULL,
                last_login DATETIME NOT NULL,
                user_name VARCHAR(255) NOT NULL,
                user_email VARCHAR(255) NOT NULL,
                PRIMARY KEY (user_id)
);


CREATE TABLE vims_log (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT(11) NOT NULL,
                action VARCHAR(255) NOT NULL,
                tbl_name VARCHAR(255) NOT NULL,
                fld_name VARCHAR(255) NOT NULL,
                old_vlu VARCHAR(255) NOT NULL,
                new_vlu VARCHAR(255) NOT NULL,
                reason LONGBLOB NOT NULL,
                timestamp DATETIME NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE vims_ubs_catalog (
                ubs_item_id INT(11) NOT NULL,
                ubs_sku VARCHAR(255) NOT NULL,
                ubs_item_name VARCHAR(255) NOT NULL,
                ubs_desc LONGBLOB NOT NULL,
                ubs_image VARCHAR(255) NOT NULL,
                ubs_map DECIMAL(2) NOT NULL,
                ubs_msrp DECIMAL(2) NOT NULL,
                item_wgt DOUBLE NOT NULL,
                crtn_date DATETIME NOT NULL,
                item_updt DATETIME NOT NULL,
                PRIMARY KEY (ubs_item_id)
);


CREATE UNIQUE INDEX vims_ubs_catalog_idx
 ON vims_ubs_catalog
 ( ubs_sku );

CREATE TABLE vims_external (
                ubs_item_id INT(11) NOT NULL,
                yahoo_sku VARCHAR(255) NOT NULL,
                amazon_sku VARCHAR(255) NOT NULL,
                ebay_sku VARCHAR(255) NOT NULL,
                sears_sku VARCHAR(255) NOT NULL,
                PRIMARY KEY (ubs_item_id)
);


CREATE TABLE vims_ubs_price (
                ubs_item_id INT(11) NOT NULL,
                ubs_price DECIMAL(2) NOT NULL,
                ubs_cost DECIMAL(2) NOT NULL,
                price_updt DATETIME NOT NULL,
                PRIMARY KEY (ubs_item_id)
);


CREATE TABLE vims_ubs_inventory (
                ubs_item_id INT(11) NOT NULL,
                ubs_inv INT(11) NOT NULL,
                inv_updt DATETIME NOT NULL,
                PRIMARY KEY (ubs_item_id)
);


CREATE TABLE vims_supplier (
                sup_id INT(11) NOT NULL,
                sup_name VARCHAR(255) NOT NULL,
                cntct_id INT(11) NOT NULL,
                loc_id INT(11) NOT NULL,
                sup_rating INT(11) NOT NULL,
                ubs_act_exec VARCHAR(255) NOT NULL,
                sup_crtn_date DATE NOT NULL,
                sup_active TINYINT(11) NOT NULL,
                sup_term_date DATE NOT NULL,
                PRIMARY KEY (sup_id)
);


CREATE TABLE vims_import_log (
                id INT AUTO_INCREMENT NOT NULL,
                sup_id INT(11) NOT NULL,
                imp_date DATE NOT NULL,
                imp_time TIME NOT NULL,
                imp_status VARCHAR(255) NOT NULL,
                stts_date DATETIME NOT NULL,
                imp_try INT(11) NOT NULL,
                PRIMARY KEY (id)
);


CREATE TABLE vims_sup_rule (
                rule_id INT(11) NOT NULL,
                sup_id INT(11) NOT NULL,
                rule_var1 DOUBLE NOT NULL,
                rule_var2 DOUBLE NOT NULL,
                rule_var3 DOUBLE NOT NULL,
                rule_var4 DOUBLE NOT NULL,
                rule_var5 DOUBLE NOT NULL,
                rule_act1 INT(11) NOT NULL,
                rule_act2 INT(11) NOT NULL,
                rule_act3 INT(11) NOT NULL,
                PRIMARY KEY (rule_id, sup_id)
);


CREATE TABLE vims_item_shipping (
                ubs_item_id INT(11) NOT NULL,
                sup_id INT(11) NOT NULL,
                ship_days INT(11) NOT NULL,
                ship_cost DECIMAL(2) NOT NULL,
                updated DATETIME NOT NULL,
                PRIMARY KEY (ubs_item_id)
);


CREATE TABLE vims_sup_sheet (
                sup_id INT(11) NOT NULL,
                user_id INT(11) NOT NULL,
                entry_date DATETIME NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                status VARCHAR(255) NOT NULL,
                stts_date DATETIME NOT NULL,
                PRIMARY KEY (sup_id)
);


CREATE TABLE vims_sup_new_item (
                sup_id INT(11) NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                row_num INT(11) NOT NULL,
                sku VARCHAR(255) NOT NULL,
                mpn VARCHAR(255) NOT NULL,
                mfc_name VARCHAR(255) NOT NULL,
                upc VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                sup_inv INT(11) NOT NULL,
                sup_price DECIMAL(2) NOT NULL,
                full_row LONGBLOB NOT NULL,
                crtn_date DATETIME NOT NULL,
                user_id INT(11) NOT NULL,
                action LONGBLOB NOT NULL,
                actn_date DATETIME NOT NULL,
                PRIMARY KEY (sup_id, file_name, row_num)
);


CREATE TABLE vims_sup_exception (
                sup_id INT(11) NOT NULL,
                ubs_item_id INT(11) NOT NULL,
                sku VARCHAR(255) NOT NULL,
                mpn VARCHAR(255) NOT NULL,
                mfc_name VARCHAR(255) NOT NULL,
                upc VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                sup_inv INT(11) NOT NULL,
                sup_price DECIMAL(2) NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                row_num INT(11) NOT NULL,
                full_row LONGBLOB NOT NULL,
                notes LONGBLOB NOT NULL,
                crtn_date DATETIME NOT NULL,
                user_id INT(11) NOT NULL,
                action LONGBLOB NOT NULL,
                actn_date DATETIME NOT NULL,
                PRIMARY KEY (sup_id, ubs_item_id)
);


CREATE TABLE vims_sup_map_extra (
                sup_id INT(11) NOT NULL,
                col INT(11) NOT NULL,
                vlu VARCHAR(255) NOT NULL,
                PRIMARY KEY (sup_id, col)
);


CREATE TABLE vims_sup_item_unmap (
                sup_id INT(11) NOT NULL,
                unmap_id INT AUTO_INCREMENT NOT NULL,
                sku VARCHAR(255) NOT NULL,
                mpn VARCHAR(255) NOT NULL,
                mfc_name VARCHAR(255) NOT NULL,
                upc VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (sup_id, unmap_id)
);


CREATE TABLE vims_sup_catalog (
                sup_id INT(11) NOT NULL,
                ubs_item_id INT(11) NOT NULL,
                sup_inv INT(11) NOT NULL,
                sup_price DECIMAL(2) NOT NULL,
                inv_updt DATETIME NOT NULL,
                price_updt DATETIME NOT NULL,
                PRIMARY KEY (sup_id, ubs_item_id)
);


CREATE TABLE vims_sup_location (
                loc_id INT AUTO_INCREMENT NOT NULL,
                sup_id INT(11) NOT NULL,
                loc_addr VARCHAR(255) NOT NULL,
                loc_city VARCHAR(255) NOT NULL,
                loc_state VARCHAR(255) NOT NULL,
                loc_zip VARCHAR(255) NOT NULL,
                loc_cntry VARCHAR(255) NOT NULL,
                loc_type VARCHAR(255) NOT NULL,
                PRIMARY KEY (loc_id)
);


CREATE TABLE vims_multi_inventory (
                sup_id INT(11) NOT NULL,
                ubs_item_id INT(11) NOT NULL,
                loc_id INT(11) NOT NULL,
                sup_inv INT(11) NOT NULL,
                PRIMARY KEY (sup_id, ubs_item_id, loc_id)
);


CREATE TABLE vims_multi_warehouse (
                loc_id INT(11) NOT NULL,
                sup_id INT(11) NOT NULL,
                qntty INT(11) NOT NULL,
                PRIMARY KEY (loc_id, sup_id)
);


CREATE INDEX vims_multi_warehouse_idx
 ON vims_multi_warehouse
 ( sup_id );

CREATE TABLE vims_sup_contact (
                cntct_id INT AUTO_INCREMENT NOT NULL,
                sup_id INT(11) NOT NULL,
                cntct_name VARCHAR(255) NOT NULL,
                cntct_dpmt VARCHAR(255) NOT NULL,
                cntct_pri_phone VARCHAR(255) NOT NULL,
                ntct_sec_phone VARCHAR(255) NOT NULL,
                cntct_email VARCHAR(255) NOT NULL,
                PRIMARY KEY (cntct_id)
);


CREATE TABLE vims_sup_col_map (
                sup_id INT(11) NOT NULL,
                info_type VARCHAR(255) NOT NULL,
                uri VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                pwd VARCHAR(255) NOT NULL,
                conn_type VARCHAR(255) NOT NULL,
                zipped TINYINT DEFAULT 0 NOT NULL,
                zip_fname VARCHAR(255) NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                file_type VARCHAR(255) NOT NULL,
                skip_rows INT(11) NOT NULL,
                header VARCHAR(255) NOT NULL,
                sku VARCHAR(255) NOT NULL,
                mpn VARCHAR(255) NOT NULL,
                mfc_name VARCHAR(255) NOT NULL,
                upc VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                qntty INT(11) NOT NULL,
                price DECIMAL(2) NOT NULL,
                multi TINYINT DEFAULT 0 NOT NULL,
                constr_id VARCHAR(255) NOT NULL,
                delimiter VARCHAR(255) NOT NULL,
                updated DATETIME NOT NULL,
                PRIMARY KEY (sup_id, info_type)
);


CREATE TABLE vims_sup_item_map (
                sup_id INT(11) NOT NULL,
                ubs_item_id INT(11) NOT NULL,
                sku VARCHAR(255) NOT NULL,
                mpn VARCHAR(255) NOT NULL,
                mfc_name VARCHAR(255) NOT NULL,
                upc VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (sup_id, ubs_item_id)
);


ALTER TABLE vims_rule ADD CONSTRAINT vims_action_vims_rule_fk
FOREIGN KEY (rule_act3)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_rule ADD CONSTRAINT vims_action_vims_rule_fk1
FOREIGN KEY (rule_act2)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_rule ADD CONSTRAINT vims_action_vims_rule_fk2
FOREIGN KEY (rule_act1)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_rule ADD CONSTRAINT vims_action_vims_sup_rule_fk
FOREIGN KEY (rule_act1)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_rule ADD CONSTRAINT vims_action_vims_sup_rule_fk1
FOREIGN KEY (rule_act2)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_rule ADD CONSTRAINT vims_action_vims_sup_rule_fk2
FOREIGN KEY (rule_act3)
REFERENCES vims_action (act_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_rule ADD CONSTRAINT vims_rules_vims_sup_rule_fk
FOREIGN KEY (rule_id)
REFERENCES vims_rule (rule_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_user ADD CONSTRAINT vims_role_vims_user_fk
FOREIGN KEY (role_id)
REFERENCES vims_role (role_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_sheet ADD CONSTRAINT vims_user_vims_sup_sheet_fk
FOREIGN KEY (user_id)
REFERENCES vims_user (user_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_exception ADD CONSTRAINT vims_user_vims_sup_exception_fk
FOREIGN KEY (user_id)
REFERENCES vims_user (user_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_new_item ADD CONSTRAINT vims_user_vims_sup_new_item_fk
FOREIGN KEY (user_id)
REFERENCES vims_user (user_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_log ADD CONSTRAINT vims_user_vims_log_fk
FOREIGN KEY (user_id)
REFERENCES vims_user (user_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_item_map ADD CONSTRAINT vims_ubs_catalog_vims_sup_item_map_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_catalog ADD CONSTRAINT vims_ubs_catalog_vims_sup_catalog_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_ubs_inventory ADD CONSTRAINT vims_ubs_catalog_vims_ubs_inventory_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_ubs_price ADD CONSTRAINT vims_ubs_catalog_vims_ubs_price_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_multi_inventory ADD CONSTRAINT vims_ubs_catalog_vims_multi_inventory_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_exception ADD CONSTRAINT vims_ubs_catalog_vims_sup_exception_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_item_shipping ADD CONSTRAINT vims_ubs_catalog_vims_item_shipping_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_external ADD CONSTRAINT vims_ubs_catalog_vims_external_fk
FOREIGN KEY (ubs_item_id)
REFERENCES vims_ubs_catalog (ubs_item_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_item_map ADD CONSTRAINT vims_supplier_vims_sup_item_map_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_contact ADD CONSTRAINT vims_supplier_vims_sup_contact_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_col_map ADD CONSTRAINT vims_supplier_vims_sup_col_map_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_location ADD CONSTRAINT vims_supplier_vims_sup_location_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_catalog ADD CONSTRAINT vims_supplier_vims_sup_catalog_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_item_unmap ADD CONSTRAINT vims_supplier_vims_sup_item_unmap_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_multi_inventory ADD CONSTRAINT vims_supplier_vims_multi_inventory_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_map_extra ADD CONSTRAINT vims_supplier_vims_sup_map_extra_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_multi_warehouse ADD CONSTRAINT vims_supplier_vims_multi_warehouse_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_exception ADD CONSTRAINT vims_supplier_vims_sup_exception_fk1
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_new_item ADD CONSTRAINT vims_supplier_vims_sup_new_item_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_sheet ADD CONSTRAINT vims_supplier_vims_sup_sheet_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_item_shipping ADD CONSTRAINT vims_supplier_vims_item_shipping_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_sup_rule ADD CONSTRAINT vims_supplier_vims_sup_rule_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_import_log ADD CONSTRAINT vims_supplier_vims_import_log_fk
FOREIGN KEY (sup_id)
REFERENCES vims_supplier (sup_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_multi_warehouse ADD CONSTRAINT vims_sup_location_vims_multi_warehouse_fk
FOREIGN KEY (loc_id)
REFERENCES vims_sup_location (loc_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_multi_inventory ADD CONSTRAINT vims_sup_location_vims_multi_inventory_fk
FOREIGN KEY (loc_id)
REFERENCES vims_sup_location (loc_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_supplier ADD CONSTRAINT vims_sup_location_vims_supplier_fk
FOREIGN KEY (loc_id)
REFERENCES vims_sup_location (loc_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE vims_supplier ADD CONSTRAINT vims_sup_contact_vims_supplier_fk
FOREIGN KEY (cntct_id)
REFERENCES vims_sup_contact (cntct_id)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
