<?php
session_start();
require "../../translator.php";
?>
<md-dialog ng-cloak style="width: 50%; max-height: 80%">
    <md-toolbar>
        <div class="md-toolbar-tools">
            <span ng-if="state=='viewing'"><?php t("Viewing patient") ?>...</span>
            <span ng-if="state=='editing'"><?php t("Editing patient") ?>...</span>
            <span ng-if="state=='medicate'"><?php t("Send drug") ?>...</span>
            <span ng-if="state=='history'"><?php t("Viewing history") ?>...</span>
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
                <div ng-if="state!='editing'" style="margin: auto 0 auto 24px; width: 100%">
                    <p class="md-headline" style="color: rgb(76,175,80); font-weight: bold;">{{patient.FirstName}}
                        {{patient.LastName}}</p>
                    <p ng-if="state=='viewing'" class="md-subhead" style="color: grey; font-style: italic; margin: 0; font-size: 14px">
                        Room: {{patient.BedID}}</p>
                    <p ng-if="state=='viewing'" class="md-subhead" style="color: grey; font-style: oblique; margin: 0; font-size: 14px">
                        {{patient.Hospitalized.split(" ")[0]}} &mdash;
                        {{patient.Released.split("")[0] ||"<?php t("Unreleased") ?>" }}
                    </p>

                    <div ng-if="state=='medicate'" style="margin: auto 0 auto 0px; width: 100%" flex>
                        <md-input-container style="width: 100%" flex>
                            <label><?php t("Drug") ?></label>
                            <md-select ng-model="patient.Bed">
                                <md-option value="x">
                                    Nurofen Forte
                                </md-option>
                                <md-option value="x">
                                    Ibuprofen
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div ng-if="state=='history'" style="margin: auto 0 auto 0px; width: 100%" flex>
                        //TODO: Create proper history table
                        <table class="table table-hover">
                            <thead>
                            <th style="text-align: center;"><?php t("Robot")?></th>
                            <th style="text-align: center;"><?php t("Drug")?></th>
                            <th style="text-align: center;"><?php t("Status")?></th>
                            <th style="text-align: center;"><?php t("Date")?></th>
                            </thead>
                            <tbody>
                            <tr><td style="text-align: center;">Health Bot</td><td style="text-align: center;">Nurofen Forte</td><td style="text-align: center;">Finalizat</td><td style="text-align: center;">2016-06-05 12:05:17</td></tr>
                            <tr><td style="text-align: center;">Health Bot</td><td style="text-align: center;">Nurofen Forte</td><td style="text-align: center;">Reluat</td><td style="text-align: center;">2016-06-05 12:03:47</td></tr>
                            <tr><td style="text-align: center;">Health Bot</td><td style="text-align: center;">Nurofen Forte</td><td style="text-align: center;">Întâmpinat obstacol</td><td style="text-align: center;">2016-06-05 12:03:43</td></tr>
                            <tr><td style="text-align: center;">Health Bot</td><td style="text-align: center;">Nurofen Forte</td><td style="text-align: center;">Recepționat</td><td style="text-align: center;">2016-06-05 12:03:24</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div ng-if="state=='editing'" style="margin: auto 0 auto 24px; flex: 1">
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
            <div ng-if="state=='viewing'" style="text-align: center;">{{patient.Age}} <?php t("years old") ?></div>
            <div ng-if="state=='editing'">
                <md-input-container class="md-block">
                    <label><?php t("Age") ?></label>
                    <input style="text-align: center" ng-model="patient.Age">
                </md-input-container>
            </div>
            <div ng-if="state=='viewing'" style="text-align: center; margin-top:10px">
                <p>{{patient.Address}}</p>
            </div>
            <div ng-if="state=='editing'">
                <md-input-container class="md-block">
                    <label><?php t("Address") ?></label>
                    <textarea style="text-align: center" ng-model="patient.Address"></textarea>
                </md-input-container>
            </div>
            <div ng-if="state=='viewing'" style="text-align: center; font-weight: bold; margin: 35px">{{patient.Diagnosis ||
                "<?php t("Undiagnosed") ?>"}}
            </div>
            <div ng-if="state=='editing'">
                <md-input-container class="md-block">
                    <label><?php t("Diagnosis") ?></label>
                    <input style="text-align: center" ng-model="patient.Diagnosis">
                </md-input-container>
            </div>
        </div>
    </md-dialog-content>

    <md-dialog-actions style="padding: 0; display: block; text-align: center;">
        <div ng-if="state=='viewing'">
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
        <div ng-if="state=='editing' || state=='medicate'">
            <md-button ng-click="save()">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                <md-tooltip><?php t("Confirm")?></md-tooltip>
            </md-button>
            <md-button ng-click="cancel()">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                <md-tooltip><?php t("Cancel")?></md-tooltip>
            </md-button>
        </div>
        <div ng-if="state=='history'">
            <md-button ng-click="back()">
                <i class="fa fa-chevron-circle-left"></i>
                <md-tooltip>Back</md-tooltip>
            </md-button>
        </div>
    </md-dialog-actions>

</md-dialog>
