<?php $fieldOptions = $field->value;
$weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
?>
<div class="field-flexible-hours">
    <div class="row">
        <div class="col-sm-7">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?= lang('thoughtco.mealtimes::default.start_time');?></th>
                        <th><?= lang('thoughtco.mealtimes::default.end_time');?></th>
                        <th><?= lang('thoughtco.mealtimes::default.available');?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index = 0;
                    foreach ($weekdays as $key => $day) { ?>
                        <?php
                        $hour = (isset($fieldOptions[$key])) ? $fieldOptions[$key] : ['day' => $key, 'open' => '00:00', 'close' => '23:59', 'status' => 1]
                        ?>
                        <tr>
                            <td>
                                <span><?= $day; ?></span>
                                <input
                                    type="hidden"
                                    name="<?= $field->getName(); ?>[<?= $index; ?>][day]"
                                    value="<?= $hour['day']; ?>"/>
                            </td>
                            <td>
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="<?= $field->getName() ?>[<?= $index; ?>][open]"
                                        class="form-control"
                                        autocomplete="off"
                                        value="<?= $hour['open'] ?>"
                                        <?= $field->getAttributes() ?> />
                                    <span class="input-group-prepend">
                                <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                            </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="<?= $field->getName() ?>[<?= $index; ?>][close]"
                                        class="form-control"
                                        autocomplete="off"
                                        value="<?= $hour['close'] ?>"
                                        <?= $field->getAttributes() ?> />
                                    <span class="input-group-prepend">
                                <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                            </span>
                                </div>
                            </td>
                            <td>
                                <div
                                    class="form-group switch-field"
                                    data-control="switch"
                                >
	                                <div class="field-custom-container">
	                                	<div class="custom-control custom-switch">
		                                    <input
		                                        type="checkbox"
		                                        name="<?= $field->getName() ?>[<?= $index; ?>][status]"
		                                        id="<?= $field->getId($index.'status') ?>"
		                                        class="custom-control-input"
		                                        value="1"
		                                        <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
		                                        <?= isset($hour['status']) && $hour['status'] == 1 ? 'checked="checked"' : '' ?>
		                                        <?= $field->getAttributes() ?>
		                                    >
		                                    <label
		                                        class="custom-control-label"
		                                        for="<?= $field->getId($index.'status') ?>"
		                                    >
		                                    	<?= lang('thoughtco.mealtimes::default.available_yes_no');?>
		                                    </label>                                	
	                                	</div>
	                                </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $index++;
                        ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>	