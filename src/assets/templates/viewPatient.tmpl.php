<?php
session_start();
require "../../translator.php";
?>
<md-dialog ng-cloak style="width: 50%; max-height: 80%">
    <md-toolbar>
        <div class="md-toolbar-tools">
            <span ng-show="state=='viewing'"><?php t("Viewing patient") ?></span>
            <span ng-show="state=='editing'"><?php t("Editing patient") ?></span>
            <span ng-show="state=='medicate'"><?php t("Send drug") ?></span>
            <span ng-show="state=='history'"><?php t("Viewing history") ?></span>
            <span flex></span>
            <md-button class="md-icon-button" ng-click="close()" md-autofocus>
                <md-icon><i class="fa fa-close"></i></md-icon>
            </md-button>
        </div>
    </md-toolbar>
    <md-dialog-content>
        <div class="md-dialog-content">
            <div style="display: flex;">
                <div style="width: 25%">
                    <img style="width: 100%"
                         ng-src="assets/img/patients/{{ patient.Image || 'person_placeholder' }}.png"></img>
                </div>
                <div ng-show="state!='editing'" style="margin: auto 0 auto 24px; width: 100%">
                    <p class="md-headline" style="color: rgb(76,175,80); font-weight: bold;">{{patient.FirstName}}
                        {{patient.LastName}}</p>
                    <p ng-show="state=='viewing'" class="md-subhead" style="color: grey; font-style: italic; margin: 0; font-size: 14px">
                        <?php t("Room")?>: {{patient.Bed.Room || patient.BedID}}</p>
                    <p ng-show="state=='viewing'" class="md-subhead" style="color: grey; font-style: oblique; margin: 0; font-size: 14px">
                        {{patient.Hospitalized.split(" ")[0]}} &mdash;
                        {{patient.Released.split("")[0] ||"<?php t("Unreleased") ?>" }}
                    </p>

                    <div ng-show="state=='medicate'" style="margin: auto 0 auto 0px; width: 100%" flex>
                        <md-input-container style="width: 100%" flex>
                            <label><?php t("Drug") ?></label>
                            <md-select ng-model="sentDrug" md-on-open="loadDrugs()">
                                <md-option ng-repeat="drug in drugs" ng-value="{{drug.ID}}">
                                    {{drug.Name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div ng-show="state=='history'" style="margin: auto 0 auto 0px; width: 100%" flex>
                        <md-progress-circular ng-show="ajax" md-mode="indeterminate"></md-progress-circular>
                        <table ng-hide="ajax" class="table table-hover">
                            <thead>
                            <th style="text-align: center;"><?php t("Robot")?></th>
                            <th style="text-align: center;"><?php t("Drug")?></th>
                            <th style="text-align: center;"><?php t("Status")?></th>
                            <th style="text-align: center;"><?php t("Date")?></th>
                            </thead>
                            <tbody>
                                <tr ng-repeat="log in logs"><td style="text-align: center;">{{log.RobotName}}</td><td style="text-align: center;">{{log.DrugName}}</td><td style="text-align: center;">{{log.Status}}</td><td style="text-align: center;">{{log.Timestamp}}</td></tr>
                                <tr ng-show="!logs"><td colspan="4" style="color: grey; font-style: italic; text-align: center;"><?php t("There are no records to be displayed")?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div ng-show="state=='editing'" style="margin: auto 0 auto 24px; flex: 1">
                    <div style="font-size:20px; rgb(76,175,80); display: flex">
                        <md-input-container flex>
                            <label><?php t("First Name") ?></label>
                            <input ng-model="patient.FirstName">
                        </md-input-container>
                        <md-input-container flex>
                            <label><?php t("Last Name") ?></label>
                            <input ng-model="patient.LastName">
                        </md-input-container>
                    </div>
                    <div style="margin-top: -6%">
                        <md-input-container style="width: 100%" flex>
                            <label><?php t("Assign bed") ?></label>
                            <md-select ng-model="patient.BedID" md-on-load="loadBeds()">
                                <md-option ng-repeat="bed in beds" ng-value="{{bed.ID}}">
                                    {{bed.Room}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </div>

            </div>
            <div ng-show="state=='viewing'" style="text-align: center;">{{patient.Age}} <?php t("years old") ?></div>
            <div ng-show="state=='editing'" style="display: flex;">
                <md-input-container class="md-block" style="flex:1">
                    <label><?php t("Age") ?></label>
                    <input style="text-align: center" ng-model="patient.Age">
                </md-input-container>
                <md-input-container class="md-block" style="flex: 5"">
                    <label><?php t("CNP") ?></label>
                    <input style="text-align: center" ng-model="patient.CNP">
                </md-input-container>
            </div>
            <div ng-show="state=='viewing'" style="text-align: center; margin-top:10px">
                <p>{{patient.Address}}</p>
            </div>
            <div ng-show="state=='editing'">
                <md-input-container class="md-block">
                    <label><?php t("Address") ?></label>
                    <textarea style="text-align: center" ng-model="patient.Address"></textarea>
                </md-input-container>
            </div>
            <div ng-show="state=='viewing'" style="text-align: center; font-weight: bold; margin: 35px">{{patient.Diagnosis ||
                "<?php t("Undiagnosed") ?>"}}
            </div>
            <div ng-show="state=='editing'">
                <md-input-container class="md-block">
                    <label><?php t("Diagnosis") ?></label>
                    <input style="text-align: center" ng-model="patient.Diagnosis">
                </md-input-container>
            </div>
        </div>
    </md-dialog-content>

    <md-dialog-actions style="padding: 0; display: block; text-align: center;">
        <div ng-show="state=='viewing'">
            <md-button ng-click="edit()">
                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                <md-tooltip><?php t("Edit patient");?></md-tooltip>
            </md-button>
            <md-button ng-click="medicate()">
                <i class="fa fa-medkit" aria-hidden="true"></i>
                <md-tooltip><?php t("Send drug")?></md-tooltip>
            </md-button>
            <md-button ng-click="history()">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                <md-tooltip><?php t("View history")?></md-tooltip>
            </md-button>
            <md-button ng-click="release()">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <md-tooltip><?php t("Release patient")?></md-tooltip>
            </md-button>
        </div>
        <div ng-show="state=='editing' || state=='medicate'">
            <md-button ng-click="save()" ng-disabled="state=='medicate' && !sentDrug">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                <md-tooltip><?php t("Confirm")?></md-tooltip>
            </md-button>
            <md-button ng-click="cancel()">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                <md-tooltip><?php t("Cancel")?></md-tooltip>
            </md-button>
        </div>
        <div ng-show="state=='history'">
            <md-button ng-click="back()">
                <i class="fa fa-chevron-circle-left"></i>
                <md-tooltip><?php t("Back")?></md-tooltip>
            </md-button>
        </div>
    </md-dialog-actions>

</md-dialog>
