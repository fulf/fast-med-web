<?php
    session_start();
    require "../../translator.php";
?>
<md-dialog ng-cloak style="width: 50%; max-height: 80%">
    <md-toolbar>
        <div class="md-toolbar-tools">
            <span><?php t("Adding patient") ?>...</span>
            <span flex></span>
            <md-button class="md-icon-button" ng-click="close()">
                <md-icon><i class="fa fa-close"></i></md-icon>
            </md-button>
        </div>
    </md-toolbar>
    <md-dialog-content>
        <div class="md-dialog-content">
            <div style="display: flex;">
                <div flex>
                    <div style="font-size:20px;" layout-gt-sm="row">
                        <md-input-container flex class="md-block">
                            <label><?php t("First Name") ?></label>
                            <input ng-model="patient.FirstName">
                        </md-input-container>
                        <md-input-container flex class="md-block">
                            <label><?php t("Last Name") ?></label>
                            <input ng-model="patient.LastName">
                        </md-input-container>
                    </div>
                    <div>
                        <md-input-container style="width: 100%" flex>
                            <label><?php t("Assign bed") ?></label>
                            <md-select ng-model="patient.Bed">
                                <md-option value="x">
                                    Marie Curie 1
                                </md-option>
                                <md-option value="x">
                                    Marie Curie 2
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </div>
            </div>
            <div>
                <md-input-container class="md-block">
                    <label><?php t("Age") ?></label>
                    <input style="text-align: center" ng-model="patient.Age">
                </md-input-container>
            </div>
            <div>
                <md-input-container class="md-block">
                    <label><?php t("Address") ?></label>
                    <textarea style="text-align: center" ng-model="patient.Address"></textarea>
                </md-input-container>
            </div>
            <div>
                <md-input-container class="md-block">
                    <label><?php t("Diagnosis") ?></label>
                    <input style="text-align: center" ng-model="patient.Diagnosis">
                </md-input-container>
            </div>
        </div>
    </md-dialog-content>

    <md-dialog-actions>
        <md-button class="md-raised md-primary"><?php t("Add")?></md-button>
        <md-button>Cancel</md-button>
    </md-dialog-actions>

</md-dialog>