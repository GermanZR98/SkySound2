<?php

/**
 * Application constants and messages for SkySound2
 * This file centralizes all text strings for easy maintenance and future i18n support
 */
class AppConstants
{
    // Application Messages
    const MESSAGES = [
        'LOGIN_SUCCESS' => 'Inicio de sesión exitoso',
        'LOGIN_FAILED' => 'El nombre o la contraseña no es correcta',
        'LOGOUT_SUCCESS' => 'Sesión cerrada correctamente',
        'REGISTRATION_SUCCESS' => 'Usuario registrado correctamente',
        'REGISTRATION_FAILED' => 'Error al registrar usuario',
        
        // Validation Messages
        'EMAIL_INVALID' => 'Email inválido',
        'PASSWORD_TOO_SHORT' => 'La contraseña debe tener al menos {min} caracteres',
        'NAME_TOO_SHORT' => 'El nombre debe tener al menos {min} caracteres',
        'ARTIST_TOO_SHORT' => 'El artista debe tener al menos {min} caracteres',
        'SONG_NAME_TOO_SHORT' => 'El nombre de la canción debe tener al menos {min} caracteres',
        'COMMENT_TOO_SHORT' => 'El comentario debe tener al menos {min} caracteres',
        'FIELD_REQUIRED' => 'El campo {field} es requerido',
        'ID_INVALID' => '{field} inválido',
        
        // Security Messages
        'CSRF_TOKEN_INVALID' => 'Token de seguridad inválido. Por favor, recarga la página e inténtalo de nuevo.',
        'SESSION_EXPIRED' => 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.',
        'ACCESS_DENIED' => 'Acceso denegado. No tienes permisos para realizar esta acción.',
        'LOGIN_REQUIRED' => 'Debes iniciar sesión para acceder a esta página',
        
        // CRUD Messages
        'SONG_CREATED' => 'Canción creada correctamente',
        'SONG_UPDATED' => 'Canción actualizada correctamente',
        'SONG_DELETED' => 'Canción eliminada correctamente',
        'SONG_NOT_FOUND' => 'Canción no encontrada',
        
        'COMMENT_CREATED' => 'Comentario creado correctamente',
        'COMMENT_UPDATED' => 'Comentario actualizado correctamente',
        'COMMENT_DELETED' => 'Comentario eliminado correctamente',
        'COMMENT_NOT_FOUND' => 'Comentario no encontrado',
        
        'USER_CREATED' => 'Usuario creado correctamente',
        'USER_NOT_FOUND' => 'Usuario no encontrado',
        
        // Error Messages
        'DATABASE_ERROR' => 'Error en la base de datos. Por favor, inténtalo más tarde.',
        'GENERIC_ERROR' => 'Ha ocurrido un error. Por favor, inténtalo más tarde.',
        'CONTROLLER_NOT_FOUND' => 'Controlador no encontrado',
        'OPERATION_NOT_FOUND' => 'Operación no encontrada',
        'INVALID_PARAMETERS' => 'Parámetros inválidos',
        
        // Form Labels
        'USERNAME' => 'Usuario',
        'PASSWORD' => 'Contraseña',
        'EMAIL' => 'Correo',
        'NAME' => 'Nombre',
        'ARTIST' => 'Artista',
        'SONG_NAME' => 'Nombre de canción',
        'GENRE' => 'Género',
        'ALBUM' => 'Álbum',
        'COMMENT' => 'Comentario',
        
        // Actions
        'LOGIN' => 'Entrar',
        'LOGOUT' => 'Cerrar Sesión',
        'REGISTER' => 'Registrarse',
        'CREATE' => 'Crear',
        'UPDATE' => 'Actualizar',
        'DELETE' => 'Eliminar',
        'EDIT' => 'Editar',
        'SAVE' => 'Guardar',
        'CANCEL' => 'Cancelar',
        'BACK' => 'Volver',
        
        // Navigation
        'ADD_SONG' => 'Añadir canción',
        'SONGS' => 'Canciones',
        'COMMENTS' => 'Comentarios',
        'CREATE_COMMENT' => 'Crear comentario',
        'WELCOME' => 'Bienvenido'
    ];

    // Validation Rules
    const VALIDATION_RULES = [
        'MIN_PASSWORD_LENGTH' => 3,
        'MIN_USERNAME_LENGTH' => 2,
        'MIN_NAME_LENGTH' => 2,
        'MIN_ARTIST_LENGTH' => 2,
        'MIN_SONG_NAME_LENGTH' => 2,
        'MIN_COMMENT_LENGTH' => 2,
        'MAX_USERNAME_LENGTH' => 50,
        'MAX_NAME_LENGTH' => 100,
        'MAX_ARTIST_LENGTH' => 100,
        'MAX_SONG_NAME_LENGTH' => 200,
        'MAX_GENRE_LENGTH' => 50,
        'MAX_ALBUM_LENGTH' => 100,
        'MAX_COMMENT_LENGTH' => 1000
    ];

    // Database Settings
    const DB_SETTINGS = [
        'CONNECTION_TIMEOUT' => 5,
        'QUERY_TIMEOUT' => 30,
        'MAX_RETRIES' => 3
    ];

    /**
     * Get message with parameter replacement
     */
    public static function getMessage($key, $params = [])
    {
        $message = self::MESSAGES[$key] ?? $key;
        
        foreach ($params as $param => $value) {
            $message = str_replace('{' . $param . '}', $value, $message);
        }
        
        return $message;
    }

    /**
     * Get validation rule
     */
    public static function getValidationRule($key)
    {
        return self::VALIDATION_RULES[$key] ?? null;
    }

    /**
     * Get database setting
     */
    public static function getDbSetting($key)
    {
        return self::DB_SETTINGS[$key] ?? null;
    }
}