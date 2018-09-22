<?php $osap = get_option( 'osap' ); ?>
<div class="wrap">
    <h1><?php _e( 'Additional Settings', OSAP_TEXT_DOMAIN ); ?></h1>
    <ul class="osap-field-wrap">
        <li><a class="button" rel="text"><?php _e( 'Text', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="number"><?php _e( 'Number', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="textarea"><?php _e( 'Text Area', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="checkbox"><?php _e( 'Check Box', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="select"><?php _e( 'Select', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="taxonomy"><?php _e( 'Taxonomy', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="page"><?php _e( 'Page', OSAP_TEXT_DOMAIN ); ?></a></li>
        <li><a class="button" rel="editor"><?php _e( 'Editor', OSAP_TEXT_DOMAIN ); ?></a></li>
    </ul>
    <form method="post" action="options.php">
        <?php settings_fields( 'osap-settings' ); ?>
        <div id="osap-custom-wrapper">
        <?php 
        $i = 0;
        if( !empty( $osap ) ) {
            foreach( $osap as $valueObj ){

                foreach( $valueObj as $key => $object ) {

                    switch ( $key ) {
                        case "text":
                        case "checkbox":
                        case "textarea":
                        case "editor":
                        case "page":
                                        if( !empty( $object['label'] ) ){ ?>
                                            <div class="osap-box osap-text-box">
                                                <div class="osap-header">
                                                    <div class="osap-caption">
                                                        <?php _e( $key, OSAP_TEXT_DOMAIN );?>
                                                    </div>
                                                    <div class="osap-controls">
                                                        <span class="toggle up"></span>
                                                        <span class="delete"></span>                                        
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="osap-body">
                                                    <div class="osap-row">
                                                        <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][<?php echo $key;?>][label]" value="<?php echo $object['label']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <select name="osap[<?php echo $i;?>][<?php echo $key;?>][validation]">
                                                            <option value="true" <?php selected( "true", $object['validation'] ); ?>><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="false" <?php selected( "false", $object['validation'] ); ?>><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="clear"></div>                                                    
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <textarea name="osap[<?php echo $i;?>][<?php echo $key;?>][description]"><?php echo $object['description']; ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="osap[<?php echo $i;?>][<?php echo $key;?>][type]" value="<?php echo $object['type']; ?>" />
                                                    <div class="clear"></div>
                                                </div>    
                                            </div>
                                            <?php
                                            }
                                            break;       

                        case "number":
                                        if( !empty( $object['label'] ) ){ ?>
                                            <div class="osap-box osap-number-box">
                                                <div class="osap-header">
                                                    <div class="osap-caption">
                                                        <?php _e( 'Number', OSAP_TEXT_DOMAIN );?>
                                                    </div>
                                                    <div class="osap-controls">
                                                        <span class="toggle up"></span>
                                                        <span class="delete"></span>                                        
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="osap-body">
                                                    <div class="osap-row">
                                                        <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][number][label]" value="<?php echo $object['label']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <select name="osap[<?php echo $i;?>][number][validation]">
                                                            <option value="true" <?php selected( "true", $object['validation'] ); ?>><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="false" <?php selected( "false", $object['validation'] ); ?>><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="min"><?php _e( 'Min', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][number][min]" value="<?php echo $object['min']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="max"><?php _e( 'Max', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][number][max]" value="<?php echo $object['max']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <textarea name="osap[<?php echo $i;?>][number][description]"><?php echo $object['description']; ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="osap[<?php echo $i;?>][number][type]" value="number" />
                                                    <div class="clear"></div>
                                                </div>    
                                            </div>
                                            <?php
                                            }
                                            break;

                        case "select":
                                        if( !empty( $object['label'] ) ){ ?>
                                            <div class="osap-box osap-select-box">
                                                <div class="osap-header">
                                                    <div class="osap-caption">
                                                        <?php _e( 'Select', OSAP_TEXT_DOMAIN );?>
                                                    </div>
                                                    <div class="osap-controls">
                                                        <span class="toggle up"></span>
                                                        <span class="delete"></span>                                        
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="osap-body">
                                                    <div class="osap-row">
                                                        <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][select][label]" value="<?php echo $object['label']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <select name="osap[<?php echo $i;?>][select][validation]">
                                                            <option value="true" <?php selected( "true", $object['validation'] ); ?>><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="false" <?php selected( "false", $object['validation'] ); ?>><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Values', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <textarea name="osap[<?php echo $i;?>][select][values]"><?php echo $object['values']; ?></textarea>
                                                        <em><?php _e( 'Each options separated by a single pipe symbol', OSAP_TEXT_DOMAIN ); ?></em>
                                                    </div>
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <textarea name="osap[<?php echo $i;?>][select][description]"><?php echo $object['description']; ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="osap[<?php echo $i;?>][select][type]" value="select" />
                                                    <div class="clear"></div>
                                                </div>    
                                            </div>
                                            <?php
                                            }
                                            break; 

                        case "taxonomy":
                                        if( !empty( $object['label'] ) ){ ?>
                                            <div class="osap-box osap-taxonomy-box">
                                                <div class="osap-header">
                                                    <div class="osap-caption">
                                                        <?php _e( 'Taxonomy Select', OSAP_TEXT_DOMAIN );?>
                                                    </div>
                                                    <div class="osap-controls">
                                                        <span class="toggle up"></span>
                                                        <span class="delete"></span>                                        
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="osap-body">
                                                    <div class="osap-row">
                                                        <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][taxonomy][label]" value="<?php echo $object['label']; ?>" />
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <select name="osap[<?php echo $i;?>][taxonomy][validation]">
                                                            <option value="true" <?php selected( "true", $object['validation'] ); ?>><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="false" <?php selected( "false", $object['validation'] ); ?>><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Taxonomy', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <input type="text" name="osap[<?php echo $i;?>][taxonomy][taxonomy]" value="<?php echo $object['taxonomy']; ?>" />
                                                    </div>
                                                    <div class="osap-row">
                                                        <label for="orderby"><?php _e( 'Order By', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <select name="osap[<?php echo $i;?>][taxonomy][orderby]">
                                                            <option value="ID" <?php selected( "ID", $object['orderby'] ); ?>><?php _e( 'ID', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="NAME" <?php selected( "NAME", $object['orderby'] ); ?>><?php _e( 'NAME', OSAP_TEXT_DOMAIN ); ?></option>
                                                            <option value="SLUG" <?php selected( "SLUG", $object['orderby'] ); ?>><?php _e( 'SLUG', OSAP_TEXT_DOMAIN ); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="osap-row">
                                                        <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                                                        <textarea name="osap[<?php echo $i;?>][taxonomy][description]"><?php echo $object['description']; ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="osap[<?php echo $i;?>][taxonomy][type]" value="taxonomy" />
                                                    <div class="clear"></div>
                                                </div>    
                                            </div>
                                            <?php
                                            }
                                            break;                    

                        default:
                                            break;
                    }
                    $i++;
                }
            }
        }
        ?>                                
        </div>
        <?php submit_button(); ?>
    </form>
</div>                                                                                   
<div class="osap-text-wrap hide">
    <div class="osap-box osap-text-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Text', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][text][label]" placeholder="eg: First Name" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][text][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][text][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][text][type]" value="text" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-number-wrap hide">
    <div class="osap-box osap-number-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Number', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][number][label]" placeholder="eg: First Name" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][number][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="min"><?php _e( 'Min', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][number][min]" placeholder="eg: 1" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="max"><?php _e( 'Max', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][number][max]" placeholder="eg: 10" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][number][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][number][type]" value="number" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-textarea-wrap hide">
    <div class="osap-box osap-textarea-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Textarea', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][textarea][label]" placeholder="eg: Comments" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][textarea][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
          <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][textarea][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][textarea][type]" value="textarea" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-checkbox-wrap hide">
    <div class="osap-box osap-checkbox-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Check Box', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][checkbox][label]" placeholder="eg: Software Engineer" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][checkbox][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][checkbox][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][checkbox][type]" value="checkbox" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-select-wrap hide">
    <div class="osap-box osap-select-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Select', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][select][label]" placeholder="eg: Male" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][select][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Values', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][select][values]" placeholder="eg: Apple | Banana | Grape | Orange"></textarea>
                <em><?php _e( 'Each options separated by a single pipe symbol', OSAP_TEXT_DOMAIN ); ?></em>
            </div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][select][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][select][type]" value="select" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-taxonomy-wrap hide">
    <div class="osap-box osap-taxonomy-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Taxonomy Select', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][taxonomy][label]" placeholder="eg: Male" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][taxonomy][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Taxonomy', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][taxonomy][taxonomy]" placeholder="eg: category" />
            </div>
            <div class="osap-row">
                <label for="orderby"><?php _e( 'Order By', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][taxonomy][orderby]">
                    <option value="ID"><?php _e( 'ID', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="NAME"><?php _e( 'NAME', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="SLUG"><?php _e( 'SLUG', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][taxonomy][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][taxonomy][type]" value="taxonomy" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-page-wrap hide">
    <div class="osap-box osap-page-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Page Select', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][page][label]" placeholder="eg: First Name" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][page][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][page][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][page][type]" value="page" />
            <div class="clear"></div>
        </div>    
    </div>
</div>
<div class="osap-editor-wrap hide">
    <div class="osap-box osap-editor-box">
        <div class="osap-header">
            <div class="osap-caption">
                <?php _e( 'Page Select', OSAP_TEXT_DOMAIN );?>
            </div>
            <div class="osap-controls">
                <span class="toggle up"></span>
                <span class="delete"></span>                                        
            </div>
            <div class="clear"></div>
        </div>
        <div class="osap-body">
            <div class="osap-row">
                <label for="label"><?php _e( 'Label', OSAP_TEXT_DOMAIN ); ?></label>
                <input type="text" name="osap[{id}][editor][label]" placeholder="eg: First Name" />
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="validation"><?php _e( 'Validation', OSAP_TEXT_DOMAIN ); ?></label>
                <select name="osap[{id}][editor][validation]">
                    <option value="true"><?php _e( 'Yes', OSAP_TEXT_DOMAIN ); ?></option>
                    <option value="false"><?php _e( 'No', OSAP_TEXT_DOMAIN ); ?></option>
                </select>
            </div>
            <div class="clear"></div>
            <div class="osap-row">
                <label for="description"><?php _e( 'Description', OSAP_TEXT_DOMAIN ); ?></label>
                <textarea name="osap[{id}][editor][description]" placeholder="eg: What assumptions do we need"></textarea>
            </div>
            <input type="hidden" name="osap[{id}][editor][type]" value="editor" />
            <div class="clear"></div>
        </div>    
    </div>
</div>